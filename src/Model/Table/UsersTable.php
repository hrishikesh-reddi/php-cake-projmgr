<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\User;

/**
 * Users Model — maps to users_t.
 * Auth module: login tracking + stats helpers.
 */
class UsersTable extends Table
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
            ->notEmptyString('display_name_tx', 'Name is required.');

        $validator
            ->email('email_tx')
            ->requirePresence('email_tx', 'create')
            ->notEmptyString('email_tx', 'Email is required.');

        $validator
            ->scalar('password_tx')
            ->minLength('password_tx', 8, 'Password must be at least 8 characters.')
            ->requirePresence('password_tx', 'create')
            ->notEmptyString('password_tx', 'Password is required.');

        $validator
            ->scalar('mobile_tx')
            ->maxLength('mobile_tx', 20)
            ->allowEmptyString('mobile_tx');

        return $validator;
    }

    /**
     * Hash the password before persisting, only when it changed.
     */
    public function beforeSave(\Cake\Event\EventInterface $event, \Cake\ORM\Entity $entity, \ArrayObject $options): void
    {
        if ($entity->isDirty('password_tx') && !empty($entity->password_tx)) {
            $entity->password_tx = password_hash($entity->password_tx, PASSWORD_BCRYPT);
        }
    }

    /**
     * Find an active/full user record by (case-insensitive) email.
     */
    public function findByEmail(string $email): ?User
    {
        return $this->find()
            ->where(['LOWER(email_tx)' => mb_strtolower(trim($email))])
            ->first();
    }

    /**
     * Successful login: stamp last login, clear failure counters.
     */
    public function recordLoginSuccess(User $user): User
    {
        $user->set('last_login_dt', \Cake\I18n\DateTime::now());
        $user->set('login_failures_nm', 0);
        $user->set('last_login_failure_dt', null);
        $this->save($user);

        return $user;
    }

    /**
     * Failed login: bump failure count, stamp failure time.
     */
    public function recordLoginFailure(User $user): void
    {
        $user->set('login_failures_nm', (int)$user->login_failures_nm + 1);
        $user->set('last_login_failure_dt', \Cake\I18n\DateTime::now());
        $this->save($user);
    }
}