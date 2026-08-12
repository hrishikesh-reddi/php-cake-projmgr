<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProjectTypesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('project_type_t');
        $this->setDisplayField('type_tx');
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
            ->scalar('type_tx')
            ->maxLength('type_tx', 255)
            ->requirePresence('type_tx', 'create')
            ->notEmptyString('type_tx', 'Type name is required.');

        $validator
            ->boolean('is_active_yn')
            ->allowEmptyString('is_active_yn');

        return $validator;
    }
}