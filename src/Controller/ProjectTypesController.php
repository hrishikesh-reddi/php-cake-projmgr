<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Project Types Controller
 *
 * Master-data CRUD for the project_type_t table.
 *
 * @property \App\Model\Table\ProjectTypesTable $ProjectTypes
 */
class ProjectTypesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * List all project types.
     */
    public function index(): void
    {
        $query = $this->ProjectTypes->find()
            ->orderAsc('ProjectTypes.type_tx');

        $projectTypes = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('projectTypes'));
    }

    /**
     * View a single project type.
     */
    public function view(int $id): void
    {
        $projectType = $this->ProjectTypes->get($id);
        $this->set(compact('projectType'));
    }

    /**
     * Create a new project type.
     */
    public function add(): void
    {
        $projectType = $this->ProjectTypes->newEmptyEntity();

        if ($this->request->is('post')) {
            $projectType = $this->ProjectTypes->patchEntity($projectType, $this->request->getData());

            if ($this->ProjectTypes->save($projectType)) {
                $this->Flash->success('Project type created successfully.');
                $this->redirect(['action' => 'view', $projectType->id]);
                return;
            }
            $this->Flash->error('Could not save the project type. Please fix the errors below.');
        }

        $this->set(compact('projectType'));
    }

    /**
     * Update an existing project type.
     */
    public function edit(int $id): void
    {
        $projectType = $this->ProjectTypes->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectType = $this->ProjectTypes->patchEntity($projectType, $this->request->getData());

            if ($this->ProjectTypes->save($projectType)) {
                $this->Flash->success('Project type updated successfully.');
                $this->redirect(['action' => 'view', $projectType->id]);
                return;
            }
            $this->Flash->error('Could not update the project type.');
        }

        $this->set(compact('projectType'));
    }

    /**
     * Delete a project type.
     */
    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectType = $this->ProjectTypes->get($id);

        if ($this->ProjectTypes->delete($projectType)) {
            $this->Flash->success('Project type deleted.');
        } else {
            $this->Flash->error('Could not delete the project type. It may be in use.');
        }
        $this->redirect(['action' => 'index']);
    }
}