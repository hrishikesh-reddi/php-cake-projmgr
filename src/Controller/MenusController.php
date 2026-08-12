<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Menus Controller
 *
 * Master-data CRUD for the `menu` table. Menus define application navigation
 * entries (label, action, icon). RBAC groundwork only — no permission engine.
 *
 * @property \App\Model\Table\MenusTable $Menus
 */
class MenusController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * List all menu entries.
     */
    public function index(): void
    {
        $query = $this->Menus->find()
            ->orderAsc('Menus.label');

        $menus = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('menus'));
    }

    /**
     * View a single menu entry.
     */
    public function view(int $id): void
    {
        $menu = $this->Menus->get($id);
        $this->set(compact('menu'));
    }

    /**
     * Create a new menu entry.
     */
    public function add(): void
    {
        $menu = $this->Menus->newEmptyEntity();

        if ($this->request->is('post')) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());

            if ($this->Menus->save($menu)) {
                $this->Flash->success('Menu entry created successfully.');
                $this->redirect(['action' => 'view', $menu->id]);
                return;
            }
            $this->Flash->error('Could not save the menu entry. Please fix the errors below.');
        }

        $this->set(compact('menu'));
    }

    /**
     * Update an existing menu entry.
     */
    public function edit(int $id): void
    {
        $menu = $this->Menus->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());

            if ($this->Menus->save($menu)) {
                $this->Flash->success('Menu entry updated successfully.');
                $this->redirect(['action' => 'view', $menu->id]);
                return;
            }
            $this->Flash->error('Could not update the menu entry.');
        }

        $this->set(compact('menu'));
    }

    /**
     * Delete a menu entry.
     */
    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);

        if ($this->Menus->delete($menu)) {
            $this->Flash->success('Menu entry deleted.');
        } else {
            $this->Flash->error('Could not delete the menu entry. It may be in use.');
        }
        $this->redirect(['action' => 'index']);
    }
}