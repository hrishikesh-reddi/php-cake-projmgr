<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TaskStatusesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('taskstatus_t');
        $this->setDisplayField('status_tx');
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
            ->scalar('status_tx')
            ->maxLength('status_tx', 255)
            ->requirePresence('status_tx', 'create')
            ->notEmptyString('status_tx', 'Status name is required.');

        $validator
            ->scalar('status_value_tx')
            ->maxLength('status_value_tx', 255)
            ->requirePresence('status_value_tx', 'create')
            ->notEmptyString('status_value_tx', 'Status value is required.');

        $validator
            ->boolean('is_active_nm')
            ->allowEmptyString('is_active_nm');

        return $validator;
    }
}