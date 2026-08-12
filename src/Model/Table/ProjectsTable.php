<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Projects Model — maps to `projects` table (geminitools DB)
 * CakePHP 5.x compatible.
 *
 * NOTE: The projects table has columns named `project_type` and `project_manager`
 * so associations to those concepts use propertyName aliases (type_obj, manager_obj)
 * to avoid CakePHP property name clashes.
 */
class ProjectsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('projects');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'dt_created' => 'new',
                    'dt_updated' => 'always',
                ],
            ],
        ]);

        // Status — uses status_id FK, property name 'project_status' is safe (no column clash)
        $this->belongsTo('ProjectStatuses', [
            'foreignKey'   => 'status_id',
            'className'    => 'ProjectStatuses',
            'joinType'     => 'LEFT',
            'propertyName' => 'project_status',
        ]);

        // Type — uses type_id FK but projects table also has a column `project_type`
        // so we alias the association property to 'type_obj' to avoid the clash
        $this->belongsTo('ProjectTypes', [
            'foreignKey'   => 'type_id',
            'className'    => 'ProjectTypes',
            'joinType'     => 'LEFT',
            'propertyName' => 'type_obj',
        ]);

        // Project Manager — projects table has a column `project_manager` (int FK)
        // so alias the association object to 'manager_obj'
        $this->belongsTo('ProjectManagers', [
            'foreignKey'   => 'project_manager',
            'className'    => 'Employees',
            'joinType'     => 'LEFT',
            'propertyName' => 'manager_obj',
        ]);

        // Account Manager — same pattern
        $this->belongsTo('AccountManagers', [
            'foreignKey'   => 'account_manager',
            'className'    => 'Employees',
            'joinType'     => 'LEFT',
            'propertyName' => 'account_mgr_obj',
        ]);

        $this->hasMany('Tasks', [
            'foreignKey' => 'project_id_nm',
            'className'  => 'Tasks',
        ]);

        $this->hasMany('ProjectResources', [
            'foreignKey' => 'project_id_nm',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name', 'Project name is required.');

        $validator
            ->scalar('short_name')
            ->maxLength('short_name', 255)
            ->requirePresence('short_name', 'create')
            ->notEmptyString('short_name', 'Short name is required.');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->allowEmptyDate('end_date');

        $validator
            ->integer('status_id')
            ->allowEmptyString('status_id');

        return $validator;
    }
}
