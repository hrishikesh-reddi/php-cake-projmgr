<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Departments Controller
 *
 * Master-data CRUD for the department_t table.
 *
 * @property \App\Model\Table\DepartmentsTable $Departments
 */
class DepartmentsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * List all departments.
     */
    public function index(): void
    {
        $query = $this->Departments->find()
            ->orderAsc('Departments.name_tx');

        $departments = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('departments'));
    }

    /**
     * View a single department.
     */
    public function view(int $id): void
    {
        $department = $this->Departments->get($id);
        $this->set(compact('department'));
    }

    /**
     * Create a new department.
     */
    public function add(): void
    {
        $department = $this->Departments->newEmptyEntity();

        if ($this->request->is('post')) {
            $department = $this->Departments->patchEntity($department, $this->request->getData());

            if ($this->Departments->save($department)) {
                $this->Flash->success('Department created successfully.');
                $this->redirect(['action' => 'view', $department->id]);
                return;
            }
            $this->Flash->error('Could not save the department. Please fix the errors below.');
        }

        $this->set(compact('department'));
    }

    /**
     * Update an existing department.
     */
    public function edit(int $id): void
    {
        $department = $this->Departments->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $department = $this->Departments->patchEntity($department, $this->request->getData());

            if ($this->Departments->save($department)) {
                $this->Flash->success('Department updated successfully.');
                $this->redirect(['action' => 'view', $department->id]);
                return;
            }
            $this->Flash->error('Could not update the department.');
        }

        $this->set(compact('department'));
    }

    /**
     * Delete a department.
     */
    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $department = $this->Departments->get($id);

        if ($this->Departments->delete($department)) {
            $this->Flash->success('Department deleted.');
        } else {
            $this->Flash->error('Could not delete the department. It may be in use.');
        }
        $this->redirect(['action' => 'index']);
    }
}