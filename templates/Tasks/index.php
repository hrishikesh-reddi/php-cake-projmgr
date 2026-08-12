<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $tasks
 * @var array $summary
 */
$this->assign('title', 'Tasks');
?>
<?php $this->append('css'); ?>
.badge { display:inline-block; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold; color:#fff; white-space:nowrap; }
.badge-green { background:#2e7d32; }
.badge-amber { background:#f9a825; color:#333; }
.badge-red   { background:#c62828; }
.badge-overdue { background:#8e0000; }
<?php $this->end(); ?>
<div class="tasks index content">
    <div class="page-header">
        <h3>Tasks <?= isset($currentProject) ? '— ' . h($currentProject->name) : '' ?></h3>
        <?= $this->Html->link('+ New Task', ['action' => 'add', '?' => ['project_id' => $currentProject->id ?? null]], ['class' => 'button float-right']) ?>
    </div>

    <?php if (!empty($summary)): ?>
    <div class="task-summary" style="margin-bottom:12px; padding:10px 14px; background:#f5f7fa; border:1px solid #e0e3e8; border-radius:6px;">
        <strong>Summary:</strong>
        <?= (int)$summary['total'] ?> tasks |
        Est. <?= (float)$summary['estimated_hours'] ?>h / Spent <?= (float)$summary['spent_hours'] ?>h
        <?php foreach ($summary['by_status'] as $label => $count): ?>
            <span style="margin-left:10px; color:#888;"><?= h($label) ?>: <?= (int)$count ?></span>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Task Name</th>
                <th>Project</th>
                <th>Milestone</th>
                <th>Status</th>
                <th>Effort</th>
                <th>Est. / Spent</th>
                <th>Completion</th>
                <th>Due Date</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <?php
                $badge = $task->effort_badge;
                $overdue = $task->overdue;
            ?>
            <tr>
                <td><?= $task->id ?></td>
                <td><?= h($task->task_name_tx) ?></td>
                <td><?= h($task->project->name ?? '—') ?></td>
                <td><?= h($task->milestone->title_tx ?? '—') ?></td>
                <td><?= h($task->task_status->status_tx ?? '—') ?></td>
                <td>
                    <span class="<?= $badge['class'] ?>"><?= h($badge['label']) ?></span>
                    <?php if ($overdue): ?>
                        <span class="badge badge-overdue">OVERDUE</span>
                    <?php endif; ?>
                </td>
                <td><?= h($task->estimated_hours_nm ?? 0) ?> / <?= h($task->spent_hours_nm ?? 0) ?></td>
                <td><?= $task->completion ?>%</td>
                <td><?= h($task->due_date_dt) ?></td>
                <td class="actions">
                    <?= $this->Html->link('View',   ['action' => 'view',   $task->id]) ?>
                    <?= $this->Html->link('Edit',   ['action' => 'edit',   $task->id]) ?>
                    <?= $this->Html->link('Status', ['action' => 'status', $task->id]) ?>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $task->id],
                        ['confirm' => 'Delete this task?']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>