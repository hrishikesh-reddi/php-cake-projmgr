<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use DateTime;

/**
 * Timesheets Model
 *
 * Maps to `timesheets` (geminitools DB). Tracks weekly hours per user /
 * project / task and the two-stage approval workflow (reporting manager,
 * project manager).
 *
 * @property \App\Model\Table\EmployeesTable $Users
 * @property \App\Model\Table\ProjectsTable $Projects
 * @property \App\Model\Table\TasksTable $Tasks
 * @property \App\Model\Table\EmployeesTable $ReportingManager
 * @property \App\Model\Table\EmployeesTable $ProjectManager
 */
class TimesheetsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('timesheets');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created'  => 'new',
                    'modified' => 'always',
                ],
            ],
        ]);

        // The owner — references users_t.id, which EmployeesTable maps to.
        $this->belongsTo('Users', [
            'className'  => 'Employees',
            'foreignKey' => 'user_id',
            'joinType'   => 'LEFT',
        ]);

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType'   => 'LEFT',
        ]);

        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id',
            'joinType'   => 'LEFT',
        ]);

        $this->belongsTo('ReportingManager', [
            'className'  => 'Employees',
            'foreignKey' => 'reporting_manager_id',
            'joinType'   => 'LEFT',
        ]);

        $this->belongsTo('ProjectManager', [
            'className'  => 'Employees',
            'foreignKey' => 'project_manager_id',
            'joinType'   => 'LEFT',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('year')
            ->requirePresence('year', 'create')
            ->notEmptyString('year', 'Year is required.');

        $validator
            ->integer('week_number')
            ->requirePresence('week_number', 'create')
            ->notEmptyString('week_number', 'Week number is required.');

        $validator
            ->integer('user_id')
            ->requirePresence('user_id', 'create')
            ->notEmptyString('user_id', 'User is required.');

        $validator
            ->integer('project_id')
            ->requirePresence('project_id', 'create')
            ->notEmptyString('project_id', 'Project is required.');

        $validator
            ->integer('task_id')
            ->requirePresence('task_id', 'create')
            ->notEmptyString('task_id', 'Task is required.');

        $validator
            ->integer('approved_hours')
            ->requirePresence('approved_hours', 'create')
            ->notEmptyString('approved_hours', 'Hours are required.');

        $validator
            ->scalar('user_comments')
            ->maxLength('user_comments', 65535)
            ->allowEmptyString('user_comments');

        $validator
            ->integer('reporting_manager_id')
            ->allowEmptyString('reporting_manager_id');

        $validator
            ->inList('reporting_manager_action', ['Pending', 'Approved', 'Rejected'], 'Invalid RM action.')
            ->allowEmptyString('reporting_manager_action');

        $validator
            ->integer('project_manager_id')
            ->allowEmptyString('project_manager_id');

        $validator
            ->inList('project_manager_action', ['Pending', 'Approved', 'Rejected'], 'Invalid PM action.')
            ->allowEmptyString('project_manager_action');

        $validator
            ->integer('timesheet_status')
            ->allowEmptyString('timesheet_status');

        return $validator;
    }

    /**
     * Two-stage approval. Records which side acted, the verdict, an optional
     * comment, and stamps the relevant date column. Returns true on success.
     *
     * @param string $role 'rm' (reporting manager) or 'pm' (project manager).
     * @param string $action 'Approved' or 'Rejected'.
     */
    public function approve(int $id, string $role, string $action, ?string $comment = null): bool
    {
        $ts = $this->get($id);

        if ($role === 'rm') {
            $ts->reporting_manager_action  = $action;
            $ts->reporting_manager_comment = $comment;
            $ts->rm_approved_date         = new DateTime('now');
        } elseif ($role === 'pm') {
            $ts->project_manager_action  = $action;
            $ts->project_manager_comment = $comment;
            $ts->project_manager_approved_hrs = $ts->approved_hours;
        }

        return (bool)$this->save($ts);
    }
}
