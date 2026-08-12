<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Roles Controller
 *
 * Master-data CRUD for the roles_t table. Roles feed user role assignment
 * (RBAC groundwork only — see user_roles_t / role_menu).
 *
 * @property \App\Model\Table\RolesTable $Roles
 */
class RolesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * List all roles.
     */
    public function index(): void
    {
        $query = $this->Roles->find()
            ->orderAsc('Roles.name_tx');

        $roles = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('roles'));
    }

    /**
     * View a single role.
     */
    public function view(int $id): void
    {
        $role = $this->Roles->get($id);
        $this->set(compact('role'));
    }

    /**
     * Create a new role.
     */
    public function add(): void
    {
        $role = $this->Roles->newEmptyEntity();

        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());

            if ($this->Roles->save($role)) {
                $this->Flash->success('Role created successfully.');
                $this->redirect(['action' => 'view', $role->id]);
                return;
            }
            $this->Flash->error('Could not save the role. Please fix the errors below.');
        }

        $this->set(compact('role'));
    }

    /**
     * Update an existing role.
     */
    public function edit(int $id): void
    {
        $role = $this->Roles->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());

            if ($this->Roles->save($role)) {
                $this->Flash->success('Role updated successfully.');
                $this->redirect(['action' => 'view', $role->id]);
                return;
            }
            $this->Flash->error('Could not update the role.');
        }

        $this->set(compact('role'));
    }

    /**
     * Delete a role.
     */
    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $role = $this->Roles->get($id);

        if ($this->Roles->delete($role)) {
            $this->Flash->success('Role deleted.');
        } else {
            $this->Flash->error('Could not delete the role. It may be in use.');
        }
        $this->redirect(['action' => 'index']);
    }
}