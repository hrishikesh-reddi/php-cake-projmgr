<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\DateTime;

/**
 * Timesheets Controller
 *
 * Minimal weekly-timesheets module: index / add / view / edit / delete plus
 * the two-stage approval endpoint. Everything except register/login flows
 * sits behind the AppController auth wall.
 *
 * @property \App\Model\Table\TimesheetsTable $Timesheets
 * @property \App\Model\Table\EmployeesTable  $Employees
 * @property \App\Model\Table\ProjectsTable   $Projects
 * @property \App\Model\Table\TasksTable      $Tasks
 */
class TimesheetsController extends AppController
{
    protected bool $requireAuth = true;

    protected array $publicActions = [];

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * GET /timesheets — paginated list, newest first.
     */
    public function index(): void
    {
        $query = $this->Timesheets->find()
            ->contain([
                'Users',
                'Projects',
                'Tasks',
                'ReportingManager',
                'ProjectManager',
            ])
            ->orderDesc('Timesheets.created');

        $timesheets = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('timesheets'));
    }

    /**
     * GET /timesheets/view/{id}
     *
     * Shows full timesheet. Approve / Reject buttons appear only when the
     * logged-in user matches the row's reporting_manager_id (role = rm) or
     * project_manager_id (role = pm) and that side's action is still Pending.
     */
    public function view(int $id): void
    {
        $timesheet = $this->Timesheets->get($id, [
            'contain' => [
                'Users',
                'Projects',
                'Tasks',
                'ReportingManager',
                'ProjectManager',
            ],
        ]);

        $currentUserId = (int)($this->Auth->user()['id'] ?? 0);

        $canApproveAsRm = $currentUserId !== 0
            && (int)$timesheet->reporting_manager_id === $currentUserId
            && $timesheet->reporting_manager_action === 'Pending';

        $canApproveAsPm = $currentUserId !== 0
            && (int)$timesheet->project_manager_id === $currentUserId
            && $timesheet->project_manager_action === 'Pending';

        $this->set(compact('timesheet', 'canApproveAsRm', 'canApproveAsPm'));
    }

    /**
     * GET|POST /timesheets/add
     *
     * Auto-fills year + week_number from date('Y') / date('W') and the user
     * from the session identity. Status defaults to 0 (Pending).
     */
    public function add(): void
    {
        $timesheet = $this->Timesheets->newEmptyEntity();
        $timesheet->year        = (int)date('Y');
        $timesheet->week_number = (int)date('W');
        $timesheet->user_id     = (int)($this->Auth->user()['id'] ?? 0);
        $timesheet->reporting_manager_action = 'Pending';
        $timesheet->project_manager_action   = 'Pending';
        $timesheet->timesheet_status         = 0;

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Re-pin year/week/user from server — never trust the client.
            $data['year']        = (int)date('Y');
            $data['week_number'] = (int)date('W');
            $data['user_id']     = (int)($this->Auth->user()['id'] ?? 0);
            $data['reporting_manager_action'] = $data['reporting_manager_action'] ?? 'Pending';
            $data['project_manager_action']   = $data['project_manager_action']   ?? 'Pending';
            $data['timesheet_status']         = 0;
            $data['submitted_date']           = new DateTime('now');

            $timesheet = $this->Timesheets->patchEntity($timesheet, $data);

            if ($this->Timesheets->save($timesheet)) {
                $this->Flash->success('Timesheet submitted.');
                $this->redirect(['action' => 'view', $timesheet->id]);
                return;
            }
            $this->Flash->error('Could not save the timesheet. Please fix the errors below.');
        }

        $projects  = $this->Timesheets->Projects->find('list', keyField: 'id', valueField: 'name');
        $tasks     = $this->Timesheets->Tasks->find('list', keyField: 'id', valueField: 'task_name_tx');
        $employees = $this->Timesheets->Users->find('list', keyField: 'id', valueField: 'display_name_tx');

        $this->set(compact('timesheet', 'projects', 'tasks', 'employees'));
    }

    /**
     * GET|POST /timesheets/edit/{id}
     */
    public function edit(int $id): void
    {
        $timesheet = $this->Timesheets->get($id, [
            'contain' => ['Users', 'Projects', 'Tasks'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $timesheet = $this->Timesheets->patchEntity($timesheet, $this->request->getData());

            if ($this->Timesheets->save($timesheet)) {
                $this->Flash->success('Timesheet updated.');
                $this->redirect(['action' => 'view', $timesheet->id]);
                return;
            }
            $this->Flash->error('Could not update the timesheet.');
        }

        $projects  = $this->Timesheets->Projects->find('list', keyField: 'id', valueField: 'name');
        $tasks     = $this->Timesheets->Tasks->find('list', keyField: 'id', valueField: 'task_name_tx');
        $employees = $this->Timesheets->Users->find('list', keyField: 'id', valueField: 'display_name_tx');

        $this->set(compact('timesheet', 'projects', 'tasks', 'employees'));
    }

    /**
     * POST /timesheets/delete/{id}
     */
    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $timesheet = $this->Timesheets->get($id);

        if ($this->Timesheets->delete($timesheet)) {
            $this->Flash->success('Timesheet deleted.');
        } else {
            $this->Flash->error('Could not delete the timesheet.');
        }
        $this->redirect(['action' => 'index']);
    }

    /**
     * POST /timesheets/approve/{id}
     *
     * Body params: role (rm|pm), action (Approved|Rejected), comment (string).
     * Delegates the persistence to TimesheetsTable::approve(), then bounces
     * back to the view.
     */
    public function approve(int $id): void
    {
        $this->request->allowMethod(['post']);

        $role    = (string)$this->request->getData('role');
        $action  = (string)$this->request->getData('action');
        $comment = $this->request->getData('comment');

        if (!in_array($role, ['rm', 'pm'], true)) {
            $this->Flash->error('Invalid approval role.');
            $this->redirect(['action' => 'view', $id]);
            return;
        }
        if (!in_array($action, ['Approved', 'Rejected'], true)) {
            $this->Flash->error('Invalid approval action.');
            $this->redirect(['action' => 'view', $id]);
            return;
        }

        $currentUserId = (int)($this->Auth->user()['id'] ?? 0);
        $timesheet = $this->Timesheets->get($id);

        $isAuthorized = ($role === 'rm' && (int)$timesheet->reporting_manager_id === $currentUserId)
            || ($role === 'pm' && (int)$timesheet->project_manager_id === $currentUserId);

        if (!$isAuthorized) {
            $this->Flash->error('You are not authorized to act on this timesheet.');
            $this->redirect(['action' => 'view', $id]);
            return;
        }

        if ($this->Timesheets->approve($id, $role, $action, $comment)) {
            $this->Flash->success('Timesheet ' . strtolower($action) . ' by ' . strtoupper($role) . '.');
        } else {
            $this->Flash->error('Could not record the approval.');
        }

        $this->redirect(['action' => 'view', $id]);
    }
}
