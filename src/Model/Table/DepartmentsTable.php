<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DepartmentsTable maps to `department_t`.
 */
class DepartmentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('department_t');
        $this->setDisplayField('name_tx');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at_dt' => 'new',
                    'updated_at_dt' => 'always',
                ],
            ],
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name_tx')
            ->maxLength('name_tx', 255)
            ->requirePresence('name_tx', 'create')
            ->notEmptyString('name_tx', 'Department name is required.');

        $validator
            ->boolean('is_active_yn')
            ->allowEmptyString('is_active_yn');

        return $validator;
    }
}