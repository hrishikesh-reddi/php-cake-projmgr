<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Department $department
 */
$this->assign('title', h($department->name_tx));
?>
<div class="departments view content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3><?= h($department->name_tx) ?></h3>
        <div class="actions">
            <?= $this->Html->link('Edit', ['action' => 'edit', $department->id], ['class' => 'button']) ?>
            <?= $this->Html->link('All Departments', ['action' => 'index'], ['class' => 'button secondary']) ?>
        </div>
    </div>

    <table class="vertical-table">
        <tr><th>ID</th><td><?= $department->id ?></td></tr>
        <tr><th>Name</th><td><?= h($department->name_tx) ?></td></tr>
        <tr><th>Active</th><td><?= $department->is_active_yn ? 'Yes' : 'No' ?></td></tr>
    </table>
</div>