<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TaskType $taskType
 */
$this->assign('title', h($taskType->task_type_name_tx));
?>
<div class="task-types view content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3><?= h($taskType->task_type_name_tx) ?></h3>
        <div class="actions">
            <?= $this->Html->link('Edit', ['action' => 'edit', $taskType->id], ['class' => 'button']) ?>
            <?= $this->Html->link('All Task Types', ['action' => 'index'], ['class' => 'button secondary']) ?>
        </div>
    </div>

    <table class="vertical-table">
        <tr><th>ID</th><td><?= $taskType->id ?></td></tr>
        <tr><th>Type Name</th><td><?= h($taskType->task_type_name_tx) ?></td></tr>
        <tr><th>Active</th><td><?= $taskType->is_active_nm ? 'Yes' : 'No' ?></td></tr>
    </table>
</div>