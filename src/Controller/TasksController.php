<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tasks Controller
 *
 * V1 actions: index, view, add, edit, delete, status.
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TasksController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * List tasks — optionally filtered by project.
     */
    public function index(): void
    {
        $projectId = $this->request->getQuery('project_id');

        $query = $this->Tasks->find()
            ->contain(['Projects', 'TaskStatuses', 'TaskTypes', 'CreatedByUser', 'Milestones'])
            ->orderDesc('Tasks.created_at_dt');

        if ($projectId) {
            $query->where(['Tasks.project_id_nm' => $projectId]);
        }

        $tasks = $this->paginate($query, ['limit' => 25]);

        $summary = $this->Tasks->getEffortSummary($projectId);

        if ($projectId) {
            $currentProject = $this->Tasks->Projects->get($projectId, ['fields' => ['id', 'name']]);
            $this->set(compact('currentProject'));
        }

        $this->set(compact('tasks', 'summary'));
    }

    /**
     * View a task with sub-tasks.
     */
    public function view(int $id): void
    {
        $task = $this->Tasks->get($id, [
            'contain' => [
                'Projects',
                'TaskStatuses',
                'TaskTypes',
                'CreatedByUser',
                'Milestones',
                'SubTasks' => ['TaskStatuses'],
            ],
        ]);
        $this->set(compact('task'));
    }

    /**
     * Create a new task.
     */
    public function add(): void
    {
        $task = $this->Tasks->newEmptyEntity();

        // Pre-select project when coming from a project page (/tasks/add?project_id=X)
        if ($projectIdFromUrl = $this->request->getQuery('project_id')) {
            $task->project_id_nm = (int)$projectIdFromUrl;
        }

        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            $task->uniq_id = uniqid('tsk_', true);

            if ($this->Tasks->save($task)) {
                $this->Flash->success('Task created successfully.');
                $this->redirect(['action' => 'view', $task->id]);
                return;
            }
            $this->Flash->error('Could not save the task. Please fix the errors below.');
        }

        $projects   = $this->Tasks->Projects->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $statuses   = $this->Tasks->TaskStatuses->find('list', ['keyField' => 'id', 'valueField' => 'status_tx']);
        $types      = $this->Tasks->TaskTypes->find('list', ['keyField' => 'id', 'valueField' => 'task_type_name_tx']);
        $employees  = $this->Tasks->CreatedByUser->find('list', ['keyField' => 'id', 'valueField' => 'display_name_tx']);
        $milestones = $this->Tasks->Milestones->find('list', ['keyField' => 'id', 'valueField' => 'title_tx']);

        $this->set(compact('task', 'projects', 'statuses', 'types', 'employees', 'milestones'));
    }

    /**
     * Update a task.
     */
    public function edit(int $id): void
    {
        $task = $this->Tasks->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());

            if ($this->Tasks->save($task)) {
                $this->Flash->success('Task updated successfully.');
                $this->redirect(['action' => 'view', $task->id]);
                return;
            }
            $this->Flash->error('Could not update the task.');
        }

        $projects  = $this->Tasks->Projects->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $statuses  = $this->Tasks->TaskStatuses->find('list', ['keyField' => 'id', 'valueField' => 'status_tx']);
        $types     = $this->Tasks->TaskTypes->find('list', ['keyField' => 'id', 'valueField' => 'task_type_name_tx']);
        $employees = $this->Tasks->CreatedByUser->find('list', ['keyField' => 'id', 'valueField' => 'display_name_tx']);
        $milestones = $this->Tasks->Milestones->find('list', ['keyField' => 'id', 'valueField' => 'title_tx']);

        $this->set(compact('task', 'projects', 'statuses', 'types', 'employees', 'milestones'));
    }

    /**
     * Delete a task.
     */
    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $task = $this->Tasks->get($id);

        if ($this->Tasks->delete($task)) {
            $this->Flash->success('Task deleted.');
        } else {
            $this->Flash->error('Could not delete the task.');
        }
        $this->redirect(['action' => 'index']);
    }

    /**
     * Status endpoint.
     * GET /tasks/{id}/status
     */
    public function status(int $id): void
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['TaskStatuses', 'Projects'],
        ]);

        if ($this->request->is('json')) {
            $this->set([
                'id'              => $task->id,
                'task_name'       => $task->task_name_tx,
                'project'         => $task->project->name ?? null,
                'status'          => $task->task_status->status_tx ?? 'Unknown',
                'completion'      => $task->completion,
                'estimated_hours' => $task->estimated_hours_nm,
                'spent_hours'     => $task->spent_hours_nm,
                'due_date'        => $task->due_date_dt,
                '_serialize'      => ['id', 'task_name', 'project', 'status', 'completion', 'estimated_hours', 'spent_hours', 'due_date'],
            ]);
            return;
        }

        $this->set(compact('task'));
    }
}
