<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
$this->assign('title', h($role->name_tx));
?>
<div class="roles view content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3><?= h($role->name_tx) ?></h3>
        <div class="actions">
            <?= $this->Html->link('Edit', ['action' => 'edit', $role->id], ['class' => 'button']) ?>
            <?= $this->Html->link('All Roles', ['action' => 'index'], ['class' => 'button secondary']) ?>
        </div>
    </div>

    <table class="vertical-table">
        <tr><th>ID</th><td><?= $role->id ?></td></tr>
        <tr><th>Name</th><td><?= h($role->name_tx) ?></td></tr>
        <tr><th>Short Name</th><td><?= h($role->short_name_tx) ?></td></tr>
        <tr><th>User Role ID</th><td><?= h($role->user_role_nm) ?></td></tr>
        <tr><th>Active</th><td><?= $role->is_active_nm ? 'Yes' : 'No' ?></td></tr>
    </table>
</div>