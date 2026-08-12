<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Employees Model — maps to users_t
 * CakePHP 5.x compatible
 */
class EmployeesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users_t');
        $this->setDisplayField('display_name_tx');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at_dt' => 'new',
                    'updated_at_dt' => 'always',
                ],
            ],
        ]);

        $this->belongsTo('ReportingManagers', [
            'className'  => 'Employees',
            'foreignKey' => 'reporting_manager_nm',
            'joinType'   => 'LEFT',
        ]);

        $this->hasMany('Reportees', [
            'className'  => 'Employees',
            'foreignKey' => 'reporting_manager_nm',
        ]);

        $this->hasMany('ProjectResources', [
            'foreignKey' => 'user_id_nm',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('display_name_tx')
            ->maxLength('display_name_tx', 255)
            ->requirePresence('display_name_tx', 'create')
            ->notEmptyString('display_name_tx', 'Employee name is required.');

        $validator
            ->email('email_tx')
            ->requirePresence('email_tx', 'create')
            ->notEmptyString('email_tx', 'Email is required.');

        $validator
            ->scalar('password_tx')
            ->minLength('password_tx', 8)
            ->requirePresence('password_tx', 'create')
            ->notEmptyString('password_tx', 'Password is required.');

        $validator
            ->scalar('mobile_tx')
            ->maxLength('mobile_tx', 20)
            ->allowEmptyString('mobile_tx');

        $validator
            ->scalar('designation')
            ->maxLength('designation', 45)
            ->allowEmptyString('designation');

        $validator
            ->scalar('employee_id')
            ->maxLength('employee_id', 10)
            ->allowEmptyString('employee_id');

        $validator
            ->date('joined_on')
            ->allowEmptyDate('joined_on');

        return $validator;
    }

    /**
     * Hash password before saving.
     * CakePHP 5: use Cake\Utility\Security or a simple password_hash call.
     */
    public function beforeSave(\Cake\Event\EventInterface $event, \Cake\ORM\Entity $entity, \ArrayObject $options): void
    {
        if ($entity->isDirty('password_tx') && !empty($entity->password_tx)) {
            $entity->password_tx = password_hash($entity->password_tx, PASSWORD_BCRYPT);
        }
    }
}
