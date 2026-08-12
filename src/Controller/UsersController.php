<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\User;

/**
 * Users Controller — auth module.
 *
 * login / logout / register are public; everything else requires login.
 * Tracks last login + failed login attempts per boss requirements and
 * exposes user statistics.
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    protected bool $requireAuth = true;

    protected array $publicActions = ['login', 'logout', 'register'];

    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * GET  /login     — show sign-in form.
     * POST /login     — verify credentials, track last login / failures.
     */
    public function login()
    {
        if ($this->Auth->isLoggedIn()) {
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $email    = (string)$this->request->getData('email');
            $password = (string)$this->request->getData('password');

            $record = $this->Users->findByEmail($email);
            if ($record && (int)$record->activate_yn_nm === 1 && password_verify($password, (string)$record->password_tx)) {
                $record = $this->Users->recordLoginSuccess($record);

                $this->Auth->login([
                    'id'             => (int)$record->id,
                    'display_name_tx' => $record->display_name_tx,
                    'email_tx'       => $record->email_tx,
                    'employee_id'    => $record->employee_id,
                ]);

                $this->Flash->success('Welcome back, ' . $record->display_name_tx . '.');
                return $this->redirect(['action' => 'index']);
            }

            if ($record) {
                $this->Users->recordLoginFailure($record);
            }
            $this->Flash->error('Invalid email or password.');
        }

        $this->set('title', 'Sign in');
    }

    /**
     * GET /logout — clear the session identity.
     */
    public function logout()
    {
        $this->Auth->logout();
        $this->Flash->success('You have been signed out.');

        return $this->redirect(['action' => 'login']);
    }

    /**
     * GET /register — create a self-service account.
     */
    public function register()
    {
        if ($this->Auth->isLoggedIn()) {
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $confirm = $data['confirm_password'] ?? null;

            if (($data['password_tx'] ?? null) !== $confirm) {
                $this->Flash->error('Password confirmation does not match.');
            } else {
                $exists = $this->Users->find()->where(['LOWER(email_tx)' => mb_strtolower((string)($data['email_tx'] ?? ''))])->count();
                if ($exists > 0) {
                    $this->Flash->error('An account with this email already exists.');
                } else {
                    unset($data['confirm_password']);
                    $user = $this->Users->patchEntity($user, $data);
                    // brand-new self-service account is active immediately
                    $user->activate_yn_nm = 1;

                    if ($this->Users->save($user)) {
                        $this->Flash->success('Account created. You can now sign in.');
                        return $this->redirect(['action' => 'login']);
                    }
                    $this->Flash->error('Could not create the account. Please fix the errors below.');
                }
            }
        }

        $this->set(compact('user'));
    }

    /**
     * GET /users — list users with sign-in stats.
     */
    public function index(): void
    {
        $query = $this->Users->find()->orderByDesc('Users.id');

        $users = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('users'));
    }

    /**
     * GET /users/view/{id} — one user profile + login stats.
     */
    public function view(int $id): void
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    /**
     * GET /users/profile — the logged-in user edits their own contact info
     * and/or password. Role/employee_id can never be changed here.
     */
    public function profile(): void
    {
        $id = (int)$this->Auth->id();
        $user = $this->Users->get($id);

        if ($this->request->is(['post', 'patch', 'put'])) {
            $data = $this->request->getData();

            // Never allow a user to change their own role / employee id (req 5).
            unset($data['employee_id']);

            $newPassword = $data['password_tx'] ?? '';
            if ($newPassword !== '') {
                if (!password_verify((string)($data['current_password'] ?? ''), (string)$user->password_tx)) {
                    $this->Flash->error('Current password is incorrect.');
                    $this->set(compact('user'));
                    return;
                }
                if ($newPassword !== ($data['confirm_password'] ?? null)) {
                    $this->Flash->error('Password confirmation does not match.');
                    $this->set(compact('user'));
                    return;
                }
            } else {
                unset($data['password_tx']);
            }
            unset($data['current_password'], $data['confirm_password']);

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success('Profile updated.');
                $this->redirect(['action' => 'profile']);
                return;
            }
            $this->Flash->error('Could not update your profile. Please fix the errors below.');
        }

        $this->set(compact('user'));
    }

    /**
     * GET /users/stats — total users, active users, users with failed logins.
     */
    public function stats(): void
    {
        $totalUsers      = $this->Users->find()->count();
        $activeUsers     = $this->Users->find()->where(['activate_yn_nm' => 1])->count();
        $failedLogins    = $this->Users->find()->where(['login_failures_nm >' => 0])->count();
        $neverLoggedIn   = $this->Users->find()->where(['last_login_dt IS' => null])->count();

        $this->set(compact('totalUsers', 'activeUsers', 'failedLogins', 'neverLoggedIn'));
    }
}