<?php
/**
 * Auth module routes — UsersController.
 *
 * Auto-included by config/routes.php (every file in config/routes.d/ is loaded).
 */
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes): void {
    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/login',    ['controller' => 'Users', 'action' => 'login']);
        $builder->connect('/logout',   ['controller' => 'Users', 'action' => 'logout']);
        $builder->connect('/register', ['controller' => 'Users', 'action' => 'register']);

        // Static routes first so they win over the resource routes below.
        $builder->connect('/users/profile', ['controller' => 'Users', 'action' => 'profile']);
        $builder->connect('/users/stats',   ['controller' => 'Users', 'action' => 'stats']);

        $builder->resources('Users', [
            'only' => ['index', 'view'],
        ]);
    });
};