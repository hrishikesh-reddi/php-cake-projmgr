<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Divisions Controller
 *
 * Master-data CRUD for the division_t table.
 *
 * @property \App\Model\Table\DivisionsTable $Divisions
 */
class DivisionsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * List all divisions.
     */
    public function index(): void
    {
        $query = $this->Divisions->find()
            ->orderAsc('Divisions.name_tx');

        $divisions = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('divisions'));
    }

    /**
     * View a single division.
     */
    public function view(int $id): void
    {
        $division = $this->Divisions->get($id);
        $this->set(compact('division'));
    }

    /**
     * Create a new division.
     */
    public function add(): void
    {
        $division = $this->Divisions->newEmptyEntity();

        if ($this->request->is('post')) {
            $division = $this->Divisions->patchEntity($division, $this->request->getData());

            if ($this->Divisions->save($division)) {
                $this->Flash->success('Division created successfully.');
                $this->redirect(['action' => 'view', $division->id]);
                return;
            }
            $this->Flash->error('Could not save the division. Please fix the errors below.');
        }

        $this->set(compact('division'));
    }

    /**
     * Update an existing division.
     */
    public function edit(int $id): void
    {
        $division = $this->Divisions->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $division = $this->Divisions->patchEntity($division, $this->request->getData());

            if ($this->Divisions->save($division)) {
                $this->Flash->success('Division updated successfully.');
                $this->redirect(['action' => 'view', $division->id]);
                return;
            }
            $this->Flash->error('Could not update the division.');
        }

        $this->set(compact('division'));
    }

    /**
     * Delete a division.
     */
    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $division = $this->Divisions->get($id);

        if ($this->Divisions->delete($division)) {
            $this->Flash->success('Division deleted.');
        } else {
            $this->Flash->error('Could not delete the division. It may be in use.');
        }
        $this->redirect(['action' => 'index']);
    }
}