<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $timesheets
 */
$this->assign('title', 'Timesheets');
?>
<style>
    .ts-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        color: #fff;
    }
    .ts-badge.pending  { background: #f59e0b; }
    .ts-badge.approved { background: #16a34a; }
    .ts-badge.rejected { background: #dc2626; }
    .ts-status-pending  { background: #fef3c7; color: #92400e; padding: 2px 10px; border-radius: 12px; font-weight: 600; font-size: 12px; }
    .ts-status-approved { background: #dcfce7; color: #166534; padding: 2px 10px; border-radius: 12px; font-weight: 600; font-size: 12px; }
    .ts-status-rejected { background: #fee2e2; color: #991b1b; padding: 2px 10px; border-radius: 12px; font-weight: 600; font-size: 12px; }
</style>

<div class="timesheets index content">
    <div class="page-header">
        <h3>Timesheets</h3>
        <?= $this->Html->link('+ New Timesheet', ['action' => 'add'], ['class' => 'button float-right']) ?>
   </div>

    <table>
        <thead>
            <tr>
                <th>Year / Week</th>
                <th>User</th>
                <th>Project</th>
                <th>Task</th>
                <th>Hours</th>
                <th>RM</th>
                <th>PM</th>
                <th>Submitted</th>
                <th class="actions">Actions</th>
           </tr>
       </thead>
        <tbody>
            <?php if (count($timesheets) === 0): ?>
                <tr><td colspan="9">No timesheets yet. <?= $this->Html->link('Submit one', ['action' => 'add'])</td</tr>
            <?php endif; ?>
            <?php foreach ($timesheets as $ts): ?>
                <?php
                    $rm = $ts->reporting_manager_action ?? 'Pending';
                    $pm = $ts->project_manager_action ?? 'Pending';
                ?>
                <tr>
                    <td><?= h($ts->year) ?> / W<?= h($ts->week_number) ?></td>
                    <td><?= h($ts->user->display_name_tx ?? '—')</td>
                    <td><?= h($ts->project->name ?? '—')</td>
                    <td><?= h($ts->task->task_name_tx ?? '—')</td>
                    <td><?= h($ts->approved_hours ?? '0') ?>h</td>
                    <td><span class="ts-status-<?= strtolower($rm) ?>"><?= h($rm)</span</td>
                    <td><span class="ts-status-<?= strtolower($pm) ?>"><?= h($pm)</span</td>
                    <td><?= h($ts->submitted_date?->format('Y-m-d H:i') ?? '—')</td>
                    <td class="actions">
                        <?= $this->Html->link('View', ['action' => 'view', $ts->id]) ?>
                        <?= $this->Html->link('Edit', ['action' => 'edit', $ts->id]) ?>
                        <?= $this->Form->postLink('Delete', ['action' => 'delete', $ts->id],
                            ['confirm' => 'Delete this timesheet?']) ?>
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
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total'))</p>
   </div>
</div>
