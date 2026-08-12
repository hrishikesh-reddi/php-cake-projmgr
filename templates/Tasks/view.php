<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
$this->assign('title', h($task->task_name_tx));
?>
<?php $this->append('css'); ?>
.badge { display:inline-block; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold; color:#fff; white-space:nowrap; }
.badge-green { background:#2e7d32; }
.badge-amber { background:#f9a825; color:#333; }
.badge-red   { background:#c62828; }
.badge-overdue { background:#8e0000; }
<?php $this->end(); ?>
<div class="tasks view content">
    <div class="page-header">
        <h3><?= h($task->task_name_tx) ?></h3>
        <div class="actions">
            <?= $this->Html->link('Edit',   ['action' => 'edit',   $task->id], ['class' => 'button']) ?>
            <?= $this->Html->link('Status', ['action' => 'status', $task->id], ['class' => 'button secondary']) ?>
            <?= $this->Html->link('All Tasks', ['action' => 'index'],           ['class' => 'button secondary']) ?>
        </div>
    </div>

    <table class="vertical-table">
        <tr><th>ID</th><td><?= $task->id ?></td></tr>
        <tr><th>Project</th><td><?= h($task->project->name ?? '—') ?></td></tr>
        <tr><th>Milestone</th><td><?= h($task->milestone->title_tx ?? '—') ?></td></tr>
        <tr><th>Status</th><td><?= h($task->task_status->status_tx ?? '—') ?></td></tr>
        <tr><th>Type</th><td><?= h($task->task_type->task_type_name_tx ?? '—') ?></td></tr>
        <tr><th>Assigned To</th><td><?= h($task->created_by_user->display_name_tx ?? '—') ?></td></tr>
        <tr><th>Start Date</th><td><?= h($task->start_date_dt) ?></td></tr>
        <tr><th>Due Date</th><td><?= h($task->due_date_dt) ?></td></tr>
        <tr><th>Estimated Hours</th><td><?= h($task->estimated_hours_nm) ?></td></tr>
        <tr><th>Spent Hours</th><td><?= h($task->spent_hours_nm) ?></td></tr>
        <tr><th>Effort Status</th><td>
            <span class="<?= $task->effort_badge['class'] ?>"><?= h($task->effort_badge['label']) ?></span>
            (ratio <?= h($task->effort_ratio) ?>)
            <?php if ($task->overdue): ?>
                <span class="badge badge-overdue">OVERDUE</span>
            <?php endif; ?>
        </td></tr>
        <tr><th>Completion</th><td><?= h($task->completion) ?>%</td></tr>
        <tr><th>Priority</th><td><?= h($task->priority_nm) ?></td></tr>
        <tr><th>Description</th><td><?= nl2br(h($task->description_tx)) ?></td></tr>
        <tr><th>Comments</th><td><?= nl2br(h($task->comments)) ?></td></tr>
    </table>

    <?php if (!empty($task->sub_tasks)): ?>
    <h4>Sub-tasks (<?= count($task->sub_tasks) ?>)</h4>
    <table>
        <thead><tr><th>Name</th><th>Status</th><th>Completion</th><th></th></tr></thead>
        <tbody>
            <?php foreach ($task->sub_tasks as $sub): ?>
            <tr>
                <td><?= h($sub->task_name_tx) ?></td>
                <td><?= h($sub->task_status->status_tx ?? '—') ?></td>
                <td><?= $sub->completion ?>%</td>
                <td><?= $this->Html->link('View', ['action' => 'view', $sub->id]) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
