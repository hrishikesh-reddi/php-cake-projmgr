<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Milestones Model
 *
 * Maps to `project_milestones_t` (geminitools DB).
 */
class MilestonesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('project_milestones_t');
        $this->setDisplayField('title_tx');
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

        $this->hasMany('Tasks', [
            'className'  => 'Tasks',
            'foreignKey' => 'milestone_id_nm',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title_tx')
            ->maxLength('title_tx', 255)
            ->requirePresence('title_tx', 'create')
            ->notEmptyString('title_tx', 'Milestone title is required.');

        $validator
            ->integer('project_id_nm')
            ->requirePresence('project_id_nm', 'create')
            ->notEmptyString('project_id_nm', 'Project is required.');

        $validator
            ->inList('milestone_type', ['DELIVERY', 'FINANCIAL'], 'Invalid milestone type.')
            ->allowEmptyString('milestone_type');

        $validator
            ->scalar('description_tx')
            ->maxLength('description_tx', 255)
            ->allowEmptyString('description_tx');

        $validator
            ->integer('parent_milestone_id')
            ->allowEmptyString('parent_milestone_id');

        $validator
            ->integer('percent_complete_nm')
            ->range('percent_complete_nm', [0, 100], 'Completion must be between 0 and 100.')
            ->allowEmptyString('percent_complete_nm');

        $validator
            ->date('start_date_dt')
            ->allowEmptyDate('start_date_dt');

        $validator
            ->date('end_date_dt')
            ->allowEmptyDate('end_date_dt');

        $validator
            ->date('actual_start_date_dt')
            ->allowEmptyDate('actual_start_date_dt');

        $validator
            ->date('actual_end_date_dt')
            ->allowEmptyDate('actual_end_date_dt');

        $validator
            ->integer('duration')
            ->allowEmptyString('duration');

        $validator
            ->integer('assigned_to')
            ->allowEmptyString('assigned_to');

        $validator
            ->integer('billable_amount_nm')
            ->allowEmptyString('billable_amount_nm');

        $validator
            ->inList('status', ['New', 'In Progress', 'Completed', 'On Hold'], 'Invalid status.')
            ->allowEmptyString('status');

        return $validator;
    }
}