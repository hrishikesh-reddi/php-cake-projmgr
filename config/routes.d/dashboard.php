<?php
/**
 * ProjMgr — Dashboard routes
 *
 * `/dashboard` maps to DashboardController::index. The home route `/` is
 * already wired to DashboardController::index from config/routes.php itself
 * (so that one URL wins over the resource fallback).
 */
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes): void {
    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/dashboard', ['controller' => 'Dashboard', 'action' => 'index']);
    });
};
