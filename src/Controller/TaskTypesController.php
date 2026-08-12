<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Task Types Controller
 *
 * Master-data CRUD for the tasktypes_t table.
 *
 * @property \App\Model\Table\TaskTypesTable $TaskTypes
 */
class TaskTypesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * List all task types.
     */
    public function index(): void
    {
        $query = $this->TaskTypes->find()
            ->orderAsc('TaskTypes.task_type_name_tx');

        $taskTypes = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('taskTypes'));
    }

    /**
     * View a single task type.
     */
    public function view(int $id): void
    {
        $taskType = $this->TaskTypes->get($id);
        $this->set(compact('taskType'));
    }

    /**
     * Create a new task type.
     */
    public function add(): void
    {
        $taskType = $this->TaskTypes->newEmptyEntity();

        if ($this->request->is('post')) {
            $taskType = $this->TaskTypes->patchEntity($taskType, $this->request->getData());

            if ($this->TaskTypes->save($taskType)) {
                $this->Flash->success('Task type created successfully.');
                $this->redirect(['action' => 'view', $taskType->id]);
                return;
            }
            $this->Flash->error('Could not save the task type. Please fix the errors below.');
        }

        $this->set(compact('taskType'));
    }

    /**
     * Update an existing task type.
     */
    public function edit(int $id): void
    {
        $taskType = $this->TaskTypes->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $taskType = $this->TaskTypes->patchEntity($taskType, $this->request->getData());

            if ($this->TaskTypes->save($taskType)) {
                $this->Flash->success('Task type updated successfully.');
                $this->redirect(['action' => 'view', $taskType->id]);
                return;
            }
            $this->Flash->error('Could not update the task type.');
        }

        $this->set(compact('taskType'));
    }

    /**
     * Delete a task type.
     */
    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $taskType = $this->TaskTypes->get($id);

        if ($this->TaskTypes->delete($taskType)) {
            $this->Flash->success('Task type deleted.');
        } else {
            $this->Flash->error('Could not delete the task type. It may be in use.');
        }
        $this->redirect(['action' => 'index']);
    }
}