<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Project Statuses Controller
 *
 * Master-data CRUD for the project_status_t table.
 *
 * @property \App\Model\Table\ProjectStatusesTable $ProjectStatuses
 */
class ProjectStatusesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * List all project statuses.
     */
    public function index(): void
    {
        $query = $this->ProjectStatuses->find()
            ->orderAsc('ProjectStatuses.status_tx');

        $projectStatuses = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('projectStatuses'));
    }

    /**
     * View a single project status.
     */
    public function view(int $id): void
    {
        $projectStatus = $this->ProjectStatuses->get($id);
        $this->set(compact('projectStatus'));
    }

    /**
     * Create a new project status.
     */
    public function add(): void
    {
        $projectStatus = $this->ProjectStatuses->newEmptyEntity();

        if ($this->request->is('post')) {
            $projectStatus = $this->ProjectStatuses->patchEntity($projectStatus, $this->request->getData());

            if ($this->ProjectStatuses->save($projectStatus)) {
                $this->Flash->success('Project status created successfully.');
                $this->redirect(['action' => 'view', $projectStatus->id]);
                return;
            }
            $this->Flash->error('Could not save the project status. Please fix the errors below.');
        }

        $this->set(compact('projectStatus'));
    }

    /**
     * Update an existing project status.
     */
    public function edit(int $id): void
    {
        $projectStatus = $this->ProjectStatuses->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectStatus = $this->ProjectStatuses->patchEntity($projectStatus, $this->request->getData());

            if ($this->ProjectStatuses->save($projectStatus)) {
                $this->Flash->success('Project status updated successfully.');
                $this->redirect(['action' => 'view', $projectStatus->id]);
                return;
            }
            $this->Flash->error('Could not update the project status.');
        }

        $this->set(compact('projectStatus'));
    }

    /**
     * Delete a project status.
     */
    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectStatus = $this->ProjectStatuses->get($id);

        if ($this->ProjectStatuses->delete($projectStatus)) {
            $this->Flash->success('Project status deleted.');
        } else {
            $this->Flash->error('Could not delete the project status. It may be in use.');
        }
        $this->redirect(['action' => 'index']);
    }
}