<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Projects Controller
 *
 * V1 actions: index (list), view, add (create), edit (update), delete, status.
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 */
class ProjectsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // CakePHP 5: PaginatorComponent removed — paginate() available via controller trait
        $this->loadComponent('Flash');
    }

    /**
     * List all projects with basic status + type info.
     */
    public function index(): void
    {
        $query = $this->Projects->find()
            ->contain(['ProjectStatuses', 'ProjectTypes', 'ProjectManagers'])
            ->orderDesc('Projects.dt_created');

        $projects = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('projects'));
    }

    /**
     * View a single project with tasks and resources.
     */
    public function view(int $id): void
    {
        $project = $this->Projects->get($id, [
            'contain' => [
                'ProjectStatuses',
                'ProjectTypes',
                'ProjectManagers',
                'AccountManagers',
                'Tasks' => ['TaskStatuses'],
                'ProjectResources' => ['Employees'],
            ],
        ]);
        $this->set(compact('project'));
    }

    /**
     * Create a new project.
     */
    public function add(): void
    {
        $project = $this->Projects->newEmptyEntity();

        if ($this->request->is('post')) {
            $project = $this->Projects->patchEntity($project, $this->request->getData());
            $project->uniq_id = uniqid('prj_', true);
            $project->company_id = 1;

            if ($this->Projects->save($project)) {
                $this->Flash->success('Project created successfully.');
                $this->redirect(['action' => 'view', $project->id]);
                return;
            }
            $this->Flash->error('Could not save the project. Please fix the errors below.');
        }

        $statuses = $this->Projects->ProjectStatuses->find('list', keyField: 'id', valueField: 'status_tx');
        $types    = $this->Projects->ProjectTypes->find('list', keyField: 'id', valueField: 'type_tx');
        $managers = $this->Projects->ProjectManagers->find('list', keyField: 'id', valueField: 'display_name_tx');

        $this->set(compact('project', 'statuses', 'types', 'managers'));
    }

    /**
     * Edit / update an existing project.
     */
    public function edit(int $id): void
    {
        $project = $this->Projects->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $project = $this->Projects->patchEntity($project, $this->request->getData());

            if ($this->Projects->save($project)) {
                $this->Flash->success('Project updated successfully.');
                $this->redirect(['action' => 'view', $project->id]);
                return;
            }
            $this->Flash->error('Could not update the project.');
        }

        $statuses = $this->Projects->ProjectStatuses->find('list', ['keyField' => 'id', 'valueField' => 'status_tx']);
        $types    = $this->Projects->ProjectTypes->find('list', ['keyField' => 'id', 'valueField' => 'type_tx']);
        $managers = $this->Projects->ProjectManagers->find('list', ['keyField' => 'id', 'valueField' => 'display_name_tx']);

        $this->set(compact('project', 'statuses', 'types', 'managers'));
    }

    /**
     * Delete a project.
     */
    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $project = $this->Projects->get($id);

        if ($this->Projects->delete($project)) {
            $this->Flash->success('Project deleted.');
        } else {
            $this->Flash->error('Could not delete the project.');
        }
        $this->redirect(['action' => 'index']);
    }

    /**
     * Status endpoint — returns the current status of a project.
     * GET /projects/{id}/status
     */
    public function status(int $id): void
    {
        $project = $this->Projects->get($id, [
            'contain' => ['ProjectStatuses'],
        ]);

        // Respond as JSON if requested, otherwise render view
        if ($this->request->is('json')) {
            $this->set([
                'id'         => $project->id,
                'name'       => $project->name,
                'status_id'  => $project->status_id,
                'status'     => $project->project_status->status_tx ?? 'Unknown',
                'progress'   => $project->progress,
                'start_date' => $project->start_date,
                'end_date'   => $project->end_date,
                '_serialize' => ['id', 'name', 'status_id', 'status', 'progress', 'start_date', 'end_date'],
            ]);
            return;
        }

        $this->set(compact('project'));
    }
}
