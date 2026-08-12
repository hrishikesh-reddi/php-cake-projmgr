<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tasks Model
 *
 * Maps to `task_t` (geminitools DB).
 */
class TasksTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('task_t');
        $this->setDisplayField('task_name_tx');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at_dt' => 'new',
                    'updated_at_dt' => 'always',
                ],
            ],
        ]);

        // ----- Associations -----
        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id_nm',
            'joinType'   => 'INNER',
        ]);

        $this->belongsTo('TaskStatuses', [
            'foreignKey' => 'task_status_nm',
            'className'  => 'TaskStatuses',
            'joinType'   => 'LEFT',
        ]);

        $this->belongsTo('TaskTypes', [
            'foreignKey' => 'task_type_nm',
            'className'  => 'TaskTypes',
            'joinType'   => 'LEFT',
        ]);

        $this->belongsTo('CreatedByUser', [
            'foreignKey' => 'created_by_nm',
            'className'  => 'Employees',
            'joinType'   => 'LEFT',
        ]);

        $this->belongsTo('Milestones', [
            'foreignKey' => 'milestone_id_nm',
            'className'  => 'Milestones',
            'joinType'   => 'LEFT',
        ]);

        // Self-referential: sub-tasks
        $this->belongsTo('ParentTask', [
            'className'  => 'Tasks',
            'foreignKey' => 'parent_task_nm',
            'joinType'   => 'LEFT',
        ]);

        $this->hasMany('SubTasks', [
            'className'  => 'Tasks',
            'foreignKey' => 'parent_task_nm',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('task_name_tx')
            ->maxLength('task_name_tx', 255)
            ->requirePresence('task_name_tx', 'create')
            ->notEmptyString('task_name_tx', 'Task name is required.');

        $validator
            ->integer('project_id_nm')
            ->requirePresence('project_id_nm', 'create')
            ->notEmptyString('project_id_nm', 'Project is required.');

        $validator
            ->integer('created_by_nm')
            ->requirePresence('created_by_nm', 'create')
            ->notEmptyString('created_by_nm', 'Created by user is required.');

        $validator
            ->scalar('description_tx')
            ->allowEmptyString('description_tx');

        $validator
            ->date('start_date_dt')
            ->allowEmptyDate('start_date_dt');

        $validator
            ->date('due_date_dt')
            ->allowEmptyDate('due_date_dt');

        $validator
            ->integer('estimated_hours_nm')
            ->allowEmptyString('estimated_hours_nm');

        $validator
            ->integer('task_status_nm')
            ->allowEmptyString('task_status_nm');

        return $validator;
    }

    /**
     * Aggregate effort summary for tasks, optionally scoped to one project.
     *
     * Returns ['total' => int, 'estimated_hours' => float, 'spent_hours' => float,
     *          'by_status' => ['status_tx' => count], 'over_budget' => int].
     */
    public function getEffortSummary(int|string|null $projectId = null): array
    {
        $query = $this->find();

        $summary = $query
            ->select([
                'total'          => $query->func()->count('*'),
                'estimated_hours' => $query->func()->sum('estimated_hours_nm'),
                'spent_hours'     => $query->func()->sum('spent_hours_nm'),
            ])
            ->where([]);

        if ($projectId) {
            $summary->where(['Tasks.project_id_nm' => $projectId]);
        }

        $row = $summary->first()->toArray();

        // Count by status label
        $byStatus = $this->find()
            ->contain(['TaskStatuses'])
            ->select([
                'status_tx' => 'TaskStatuses.status_tx',
                'count'     => $query->func()->count('*'),
            ])
            ->groupBy(['TaskStatuses.status_tx'])
            ->orderAsc('TaskStatuses.status_tx');

        if ($projectId) {
            $byStatus->where(['Tasks.project_id_nm' => $projectId]);
        }

        $counts = [];
        foreach ($byStatus->all() as $r) {
            $label = $r->status_tx ?? 'Unknown';
            $counts[$label] = (int)$r->count;
        }

        return [
            'total'            => (int)($row['total'] ?? 0),
            'estimated_hours'  => (float)($row['estimated_hours'] ?? 0),
            'spent_hours'      => (float)($row['spent_hours'] ?? 0),
            'by_status'        => $counts,
        ];
    }
}
