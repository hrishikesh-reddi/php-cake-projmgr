<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Milestone $milestone
 */
$this->assign('title', h($milestone->title_tx));
?>
<div class="milestones view content">
    <div class="page-header">
        <h3><?= h($milestone->title_tx) ?></h3>
        <div class="actions">
            <?= $this->Html->link('Edit',       ['action' => 'edit', $milestone->id], ['class' => 'button']) ?>
            <?= $this->Html->link('All Milestones', ['action' => 'index'],            ['class' => 'button secondary']) ?>
        </div>
    </div>

    <table class="vertical-table">
        <tr><th>ID</th><td><?= $milestone->id ?></td></tr>
        <tr><th>Project</th><td><?= h($milestone->project->name ?? '—') ?></td></tr>
        <tr><th>Type</th><td><?= h($milestone->milestone_type ?? '—') ?></td></tr>
        <tr><th>Status</th><td><?= h($milestone->status ?? '—') ?></td></tr>
        <tr><th>% Complete</th><td><?= h($milestone->percent_complete_nm ?? 0) ?>%</td></tr>
        <tr><th>Start Date</th><td><?= h($milestone->start_date_dt) ?></td></tr>
        <tr><th>End Date</th><td><?= h($milestone->end_date_dt) ?></td></tr>
        <tr><th>Actual Start</th><td><?= h($milestone->actual_start_date_dt) ?></td></tr>
        <tr><th>Actual End</th><td><?= h($milestone->actual_end_date_dt) ?></td></tr>
        <tr><th>Currency</th><td><?= h($milestone->currency ?? '—') ?></td></tr>
        <tr><th>Billable Amount</th><td><?= h($milestone->billable_amount_nm ?? '—') ?></td></tr>
        <tr><th>Assigned To</th><td><?= h($milestone->assigned_to ?? '—') ?></td></tr>
        <tr><th>Description</th><td><?= nl2br(h($milestone->description_tx)) ?></td></tr>
        <tr><th>Comments</th><td><?= nl2br(h($milestone->comments)) ?></td></tr>
    </table>

    <?php if (!empty($milestone->tasks)): ?>
    <h4>Tasks (<?= count($milestone->tasks) ?>)</h4>
    <table>
        <thead><tr><th>Name</th><th>Status</th><th>Completion</th><th></th></tr></thead>
        <tbody>
            <?php foreach ($milestone->tasks as $task): ?>
            <tr>
                <td><?= h($task->task_name_tx) ?></td>
                <td><?= h($task->task_status->status_tx ?? '—') ?></td>
                <td><?= $task->completion ?>%</td>
                <td><?= $this->Html->link('View', ['controller' => 'Tasks', 'action' => 'view', $task->id]) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>