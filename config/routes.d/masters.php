<?php
/**
 * Master-data routes (masters feature module).
 *
 * Auto-loaded by config/routes.php via glob(config/routes.d/*.php).
 * All master controllers register simple resources() CRUD routes.
 */
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes): void {
    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->resources('ProjectStatuses', [
            'only' => ['index', 'create', 'view', 'update', 'delete'],
        ]);
        $builder->resources('TaskStatuses', [
            'only' => ['index', 'create', 'view', 'update', 'delete'],
        ]);
        $builder->resources('TaskTypes', [
            'only' => ['index', 'create', 'view', 'update', 'delete'],
        ]);
        $builder->resources('ProjectTypes', [
            'only' => ['index', 'create', 'view', 'update', 'delete'],
        ]);
        $builder->resources('Departments', [
            'only' => ['index', 'create', 'view', 'update', 'delete'],
        ]);
        $builder->resources('Divisions', [
            'only' => ['index', 'create', 'view', 'update', 'delete'],
        ]);
        $builder->resources('Roles', [
            'only' => ['index', 'create', 'view', 'update', 'delete'],
        ]);
        $builder->resources('Menus', [
            'only' => ['index', 'create', 'view', 'update', 'delete'],
        ]);
    });
};