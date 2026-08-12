<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Milestones Controller
 *
 * CRUD for project milestones (project_milestones_t).
 *
 * @property \App\Model\Table\MilestonesTable $Milestones
 */
class MilestonesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * List milestones — optionally filtered by project.
     */
    public function index(): void
    {
        $projectId = $this->request->getQuery('project_id');

        $query = $this->Milestones->find()
            ->contain(['Projects'])
            ->orderDesc('Milestones.updated_at_dt');

        if ($projectId) {
            $query->where(['Milestones.project_id_nm' => $projectId]);
        }

        $milestones = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('milestones'));
    }

    /**
     * View a milestone with its tasks.
     */
    public function view(int $id): void
    {
        $milestone = $this->Milestones->get($id, [
            'contain' => [
                'Projects',
                'Tasks' => ['TaskStatuses'],
            ],
        ]);
        $this->set(compact('milestone'));
    }

    /**
     * Create a new milestone.
     */
    public function add(): void
    {
        $milestone = $this->Milestones->newEmptyEntity();

        // Pre-select project when coming from a project page (/milestones/add?project_id=X)
        if ($projectIdFromUrl = $this->request->getQuery('project_id')) {
            $milestone->project_id_nm = (int)$projectIdFromUrl;
        }

        if ($this->request->is('post')) {
            $milestone = $this->Milestones->patchEntity($milestone, $this->request->getData());
            $milestone->uniq_id = uniqid('ms_', true);

            if ($this->Milestones->save($milestone)) {
                $this->Flash->success('Milestone created successfully.');
                $this->redirect(['action' => 'view', $milestone->id]);
                return;
            }
            $this->Flash->error('Could not save the milestone. Please fix the errors below.');
        }

        $projects = $this->Milestones->Projects->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $parents  = $this->Milestones->find('list', ['keyField' => 'id', 'valueField' => 'title_tx']);

        $this->set(compact('milestone', 'projects', 'parents'));
    }

    /**
     * Update a milestone.
     */
    public function edit(int $id): void
    {
        $milestone = $this->Milestones->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $milestone = $this->Milestones->patchEntity($milestone, $this->request->getData());

            if ($this->Milestones->save($milestone)) {
                $this->Flash->success('Milestone updated successfully.');
                $this->redirect(['action' => 'view', $milestone->id]);
                return;
            }
            $this->Flash->error('Could not update the milestone.');
        }

        $projects = $this->Milestones->Projects->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $parents  = $this->Milestones->find('list', ['keyField' => 'id', 'valueField' => 'title_tx']);

        $this->set(compact('milestone', 'projects', 'parents'));
    }

    /**
     * Delete a milestone.
     */
    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $milestone = $this->Milestones->get($id);

        if ($this->Milestones->delete($milestone)) {
            $this->Flash->success('Milestone deleted.');
        } else {
            $this->Flash->error('Could not delete the milestone.');
        }
        $this->redirect(['action' => 'index']);
    }
}