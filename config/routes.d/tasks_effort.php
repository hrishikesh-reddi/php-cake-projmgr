<?php
/**
 * ProjMgr — Task Effort + Milestones routes
 *
 * Registers Milestones resources. The existing /tasks resources are declared
 * in config/routes.php and are left untouched.
 */
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes): void {
    $routes->scope('/', function (RouteBuilder $builder): void {
        // Milestones
        $builder->resources('Milestones', [
            'only' => ['index', 'view', 'add', 'edit', 'delete'],
        ]);
    });
};