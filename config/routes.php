<?php
/**
 * ProjMgr — CakePHP 5.x Routes
 */
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        // Home → Forecasting dashboard (Agent D)
        $builder->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);

        // Projects
        $builder->resources('Projects', [
            'only' => ['index', 'view', 'add', 'edit', 'delete'],
        ]);
        $builder->connect(
            '/projects/{id}/status',
            ['controller' => 'Projects', 'action' => 'status'],
            ['id' => '\d+', 'pass' => ['id']]
        );

        // Tasks
        $builder->resources('Tasks', [
            'only' => ['index', 'view', 'add', 'edit', 'delete'],
        ]);
        $builder->connect(
            '/tasks/{id}/status',
            ['controller' => 'Tasks', 'action' => 'status'],
            ['id' => '\d+', 'pass' => ['id']]
        );

        // Employees
        $builder->resources('Employees', [
            'only' => ['index', 'view', 'add', 'edit', 'delete'],
        ]);
        $builder->connect(
            '/employees/{id}/status',
            ['controller' => 'Employees', 'action' => 'status'],
            ['id' => '\d+', 'pass' => ['id']]
        );

        $builder->fallbacks();
    });

    // Auto-include feature routes from config/routes.d/*.php
    // Each feature module registers its own routes in its own file.
    foreach (glob(__DIR__ . '/routes.d/*.php') ?: [] as $routeFile) {
        $loaded = require $routeFile;
        if (is_callable($loaded)) {
            $loaded($routes);
        }
    }
};
