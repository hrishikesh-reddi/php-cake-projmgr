<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Task Statuses Controller
 *
 * Master-data CRUD for the taskstatus_t table.
 *
 * @property \App\Model\Table\TaskStatusesTable $TaskStatuses
 */
class TaskStatusesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * List all task statuses.
     */
    public function index(): void
    {
        $query = $this->TaskStatuses->find()
            ->orderAsc('TaskStatuses.status_tx');

        $taskStatuses = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('taskStatuses'));
    }

    /**
     * View a single task status.
     */
    public function view(int $id): void
    {
        $taskStatus = $this->TaskStatuses->get($id);
        $this->set(compact('taskStatus'));
    }

    /**
     * Create a new task status.
     */
    public function add(): void
    {
        $taskStatus = $this->TaskStatuses->newEmptyEntity();

        if ($this->request->is('post')) {
            $taskStatus = $this->TaskStatuses->patchEntity($taskStatus, $this->request->getData());

            if ($this->TaskStatuses->save($taskStatus)) {
                $this->Flash->success('Task status created successfully.');
                $this->redirect(['action' => 'view', $taskStatus->id]);
                return;
            }
            $this->Flash->error('Could not save the task status. Please fix the errors below.');
        }

        $this->set(compact('taskStatus'));
    }

    /**
     * Update an existing task status.
     */
    public function edit(int $id): void
    {
        $taskStatus = $this->TaskStatuses->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $taskStatus = $this->TaskStatuses->patchEntity($taskStatus, $this->request->getData());

            if ($this->TaskStatuses->save($taskStatus)) {
                $this->Flash->success('Task status updated successfully.');
                $this->redirect(['action' => 'view', $taskStatus->id]);
                return;
            }
            $this->Flash->error('Could not update the task status.');
        }

        $this->set(compact('taskStatus'));
    }

    /**
     * Delete a task status.
     */
    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $taskStatus = $this->TaskStatuses->get($id);

        if ($this->TaskStatuses->delete($taskStatus)) {
            $this->Flash->success('Task status deleted.');
        } else {
            $this->Flash->error('Could not delete the task status. It may be in use.');
        }
        $this->redirect(['action' => 'index']);
    }
}