<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TaskStatus $taskStatus
 */
$this->assign('title', h($taskStatus->status_tx));
?>
<div class="task-statuses view content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3><?= h($taskStatus->status_tx) ?></h3>
        <div class="actions">
            <?= $this->Html->link('Edit', ['action' => 'edit', $taskStatus->id], ['class' => 'button']) ?>
            <?= $this->Html->link('All Task Statuses', ['action' => 'index'], ['class' => 'button secondary']) ?>
        </div>
    </div>

    <table class="vertical-table">
        <tr><th>ID</th><td><?= $taskStatus->id ?></td></tr>
        <tr><th>Status</th><td><?= h($taskStatus->status_tx) ?></td></tr>
        <tr><th>Value</th><td><?= h($taskStatus->status_value_tx) ?></td></tr>
        <tr><th>Active</th><td><?= $taskStatus->is_active_nm ? 'Yes' : 'No' ?></td></tr>
    </table>
</div>