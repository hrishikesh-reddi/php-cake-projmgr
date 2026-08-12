<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Employees Controller
 *
 * Maps to users_t table. V1 actions: index, view, add, edit, delete, status.
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 */
class EmployeesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * List all employees.
     */
    public function index(): void
    {
        $query = $this->Employees->find()
            ->contain(['ReportingManagers'])
            ->orderAsc('Employees.display_name_tx');

        $employees = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('employees'));
    }

    /**
     * View a single employee with their projects and tasks.
     */
    public function view(int $id): void
    {
        $employee = $this->Employees->get($id, [
            'contain' => [
                'ReportingManagers',
                'Reportees',
                'ProjectResources' => ['Projects'],
            ],
        ]);
        $this->set(compact('employee'));
    }

    /**
     * Create a new employee record.
     */
    public function add(): void
    {
        $employee = $this->Employees->newEmptyEntity();

        if ($this->request->is('post')) {
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());
            $employee->created_by_nm = 1; // TODO: replace with session user id
            $employee->updated_by_nm = 1;
            $employee->activate_yn_nm = 1;

            if ($this->Employees->save($employee)) {
                $this->Flash->success('Employee created successfully.');
                $this->redirect(['action' => 'view', $employee->id]);
                return;
            }
            $this->Flash->error('Could not save the employee. Please fix the errors below.');
        }

        $managers = $this->Employees->find('list', [
            'keyField'   => 'id',
            'valueField' => 'display_name_tx',
        ]);

        $this->set(compact('employee', 'managers'));
    }

    /**
     * Update an employee record.
     */
    public function edit(int $id): void
    {
        $employee = $this->Employees->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());
            $employee->updated_by_nm = 1; // TODO: session user id

            if ($this->Employees->save($employee)) {
                $this->Flash->success('Employee updated successfully.');
                $this->redirect(['action' => 'view', $employee->id]);
                return;
            }
            $this->Flash->error('Could not update the employee record.');
        }

        $managers = $this->Employees->find('list', [
            'keyField'   => 'id',
            'valueField' => 'display_name_tx',
        ]);

        $this->set(compact('employee', 'managers'));
    }

    /**
     * Delete an employee record.
     */
    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $employee = $this->Employees->get($id);

        if ($this->Employees->delete($employee)) {
            $this->Flash->success('Employee deleted.');
        } else {
            $this->Flash->error('Could not delete the employee.');
        }
        $this->redirect(['action' => 'index']);
    }

    /**
     * Status endpoint — returns activation status of an employee.
     * GET /employees/{id}/status
     */
    public function status(int $id): void
    {
        $employee = $this->Employees->get($id, [
            'contain' => ['ReportingManagers'],
        ]);

        if ($this->request->is('json')) {
            $this->set([
                'id'             => $employee->id,
                'employee_id'    => $employee->employee_id,
                'name'           => $employee->display_name_tx,
                'email'          => $employee->email_tx,
                'designation'    => $employee->designation,
                'is_active'      => (bool)$employee->activate_yn_nm,
                'reporting_to'   => $employee->reporting_manager->display_name_tx ?? null,
                '_serialize'     => ['id', 'employee_id', 'name', 'email', 'designation', 'is_active', 'reporting_to'],
            ]);
            return;
        }

        $this->set(compact('employee'));
    }
}
