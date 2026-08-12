<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RolesTable maps to `roles_t`.
 */
class RolesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('roles_t');
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
            ->notEmptyString('name_tx', 'Role name is required.');

        $validator
            ->scalar('short_name_tx')
            ->maxLength('short_name_tx', 45)
            ->allowEmptyString('short_name_tx');

        $validator
            ->integer('user_role_nm')
            ->allowEmptyString('user_role_nm');

        $validator
            ->boolean('is_active_nm')
            ->allowEmptyString('is_active_nm');

        return $validator;
    }
}