<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
$this->assign('title', 'Status: ' . h($task->task_name_tx));
?>
<div class="tasks status content">
    <h3>Task Status: <?= h($task->task_name_tx) ?></h3>
    <table class="vertical-table">
        <tr><th>Status</th><td><strong><?= h($task->task_status->status_tx ?? 'Unknown') ?></strong></td></tr>
        <tr><th>Completion</th><td><?= h($task->completion) ?>%</td></tr>
        <tr><th>Estimated Hours</th><td><?= h($task->estimated_hours_nm) ?></td></tr>
        <tr><th>Spent Hours</th><td><?= h($task->spent_hours_nm) ?></td></tr>
        <tr><th>Due Date</th><td><?= h($task->due_date_dt) ?></td></tr>
        <tr><th>Project</th><td><?= h($task->project->name ?? '—') ?></td></tr>
    </table>
    <div class="actions">
        <?= $this->Html->link('Full Details', ['action' => 'view', $task->id], ['class' => 'button']) ?>
    </div>
</div>
