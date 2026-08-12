<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TaskTypesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('tasktypes_t');
        $this->setDisplayField('task_type_name_tx');
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
            ->scalar('task_type_name_tx')
            ->maxLength('task_type_name_tx', 255)
            ->requirePresence('task_type_name_tx', 'create')
            ->notEmptyString('task_type_name_tx', 'Task type name is required.');

        $validator
            ->boolean('is_active_nm')
            ->allowEmptyString('is_active_nm');

        return $validator;
    }
}