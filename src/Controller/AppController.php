<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * Base for session-based auth: every controller that extends AppController
 * gets the Auth component + a `currentUser` view variable. Subclasses opt in
 * to the login wall by setting `$requireAuth = true` (see UsersController).
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * When true, every action except those in $publicActions is behind a login.
     *
     * @var bool
     */
    protected bool $requireAuth = false;

    /**
     * Actions a protected controller may reach without logging in.
     *
     * @var string[]
     */
    protected array $publicActions = [];

    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Auth', ['className' => \App\Controller\Component\AuthComponent::class]);
    }

    /**
     * Gives every view access to the logged-in identity and enforces the
     * login wall for controllers that opt in via $requireAuth.
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $user = $this->Auth->user();
        $this->set('currentUser', $user);

        if (!$this->requireAuth) {
            return;
        }

        $action = (string)$this->request->getParam('action');
        if (!in_array($action, $this->publicActions, true) && !$user) {
            $this->Flash->error('Please log in to continue.');
            $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    /**
     * Convenience alias — current user is logged in?
     */
    protected function isAuthorized(): bool
    {
        return $this->Auth->isLoggedIn();
    }
}
