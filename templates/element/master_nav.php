<?php
/**
 * Master-data cross navigation — links between all master screens.
 * @var \App\View\AppView $this
 */
?>
<div class="master-nav box" style="margin-bottom: 20px; padding: 10px 14px; border: 1px solid #dedede; border-radius: 4px; background: #fafafa;">
    <strong>Master Data:</strong>
    <?= $this->Html->link('Project Statuses', ['controller' => 'ProjectStatuses', 'action' => 'index']) ?> ·
    <?= $this->Html->link('Task Statuses', ['controller' => 'TaskStatuses', 'action' => 'index']) ?> ·
    <?= $this->Html->link('Task Types', ['controller' => 'TaskTypes', 'action' => 'index']) ?> ·
    <?= $this->Html->link('Project Types', ['controller' => 'ProjectTypes', 'action' => 'index']) ?> ·
    <?= $this->Html->link('Departments', ['controller' => 'Departments', 'action' => 'index']) ?> ·
    <?= $this->Html->link('Divisions', ['controller' => 'Divisions', 'action' => 'index']) ?> ·
    <?= $this->Html->link('Roles', ['controller' => 'Roles', 'action' => 'index']) ?> ·
    <?= $this->Html->link('Menus', ['controller' => 'Menus', 'action' => 'index']) ?>
</div>