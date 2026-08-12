<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProjectStatusesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('project_status_t');
        $this->setDisplayField('status_tx');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'dt_created' => 'new',
                    'updated_at' => 'always',
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
            ->boolean('is_active_yn')
            ->allowEmptyString('is_active_yn');

        return $validator;
    }
}