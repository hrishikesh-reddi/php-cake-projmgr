<?php
/**
 * Reports routes — weekly status reports module.
 *
 * Auto-loaded by config/routes.php via glob(config/routes.d/*.php).
 */
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes): void {
    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect(
            '/reports/weekly',
            ['controller' => 'Reports', 'action' => 'weekly']
        );

        $builder->connect(
            '/reports/project/{id}/weekly',
            ['controller' => 'Reports', 'action' => 'projectWeekly'],
            ['id' => '\d+', 'pass' => ['id']]
        );
    });
};
