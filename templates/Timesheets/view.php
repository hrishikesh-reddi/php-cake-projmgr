<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Timesheet $timesheet
 */
$this->assign('title', 'Timesheet #' . $timesheet->id);
?>
<style>
    .ts-status-pending  { background: #fef3c7; color: #92400e; padding: 2px 10px; border-radius: 12px; font-weight: 600; font-size: 12px; }
    .ts-status-approved { background: #dcfce7; color: #166534; padding: 2px 10px; border-radius: 12px; font-weight: 600; font-size: 12px; }
    .ts-status-rejected { background: #fee2e2; color: #991b1b; padding: 2px 10px; border-radius: 12px; font-weight: 600; font-size: 12px; }
    .ts-approve-btn  { background: #16a34a; color: #fff; border: 0; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600; }
    .ts-reject-btn   { background: #dc2626; color: #fff; border: 0; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600; }
    .ts-approval-block { margin-top: 16px; padding: 12px 16px; border: 1px solid #e5e7eb; border-radius: 8px; background: #f9fafb; }
    .ts-approval-block textarea { width: 100%; min-height: 60px; margin: 8px 0; padding: 6px 8px; border-radius: 4px; border: 1px solid #d1d5db; }
</style>

<div class="timesheets view content">
    <div class="page-header">
        <h3>Timesheet #<?= h($timesheet->id) ?> — Week <?= h($timesheet->week_number) ?> / <?= h($timesheet->year)</h3>
        <div class="actions">
            <?= $this->Html->link('Edit', ['action' => 'edit', $timesheet->id], ['class' => 'button']) ?>
            <?= $this->Html->link('All Timesheets', ['action' => 'index'], ['class' => 'button secondary']) ?>
       </div>
   </div>

    <table class="vertical-table">
        <tr><th>ID</th><td><?= h($timesheet->id)</td</tr>
        <tr><th>Year</th><td><?= h($timesheet->year)</td</tr>
        <tr><th>Week</th><td><?= h($timesheet->week_number)</td</tr>
        <tr><th>User</th><td><?= h($timesheet->user->display_name_tx ?? '—')</td</tr>
        <tr><th>Project</th><td><?= h($timesheet->project->name ?? '—')</td</tr>
        <tr><th>Task</th><td><?= h($timesheet->task->task_name_tx ?? '—')</td</tr>
        <tr>
            <th>Hours</th>
            <td>
                <?= h($timesheet->approved_hours ?? '0') ?>h
                <?= $timesheet->is_billable ? '<small>(billable</small>' : '' ?>
           </td>
       </tr>
        <tr><th>Submitted</th><td><?= h($timesheet->submitted_date?->format('Y-m-d H:i') ?? '—</td</tr>
        <tr><th>User Comments</th><td><?= nl2br(h($timesheet->user_comments ?? ''))</td</tr>

        <tr>
            <th>Reporting Manager</th>
            <td>
                <?= h($timesheet->reporting_manager->display_name_tx ?? '—') ?>
                &nbsp;
                <span class="ts-status-<?= strtolower((string)($timesheet->reporting_manager_action ?? 'Pending')) ?>">
                    <?= h($timesheet->reporting_manager_action ?? 'Pending') ?>
               </span>
                <?php if ($timesheet->rm_approved_date): ?>
                    <small>· <?= h($timesheet->rm_approved_date->format('Y-m-d H:i'))</small>
                <?php endif; ?>
                <?php if (!empty($timesheet->reporting_manager_comment)): ?>
                    <div><em><?= nl2br(h($timesheet->reporting_manager_comment)) ?></em></div>
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <th>Project Manager</th>
            <td>
                <?= h($timesheet->project_manager->display_name_tx ?? '—') ?>
                &nbsp;
                <span class="ts-status-<?= strtolower((string)($timesheet->project_manager_action ?? 'Pending')) ?>">
                    <?= h($timesheet->project_manager_action ?? 'Pending') ?>
               </span>
                <?php if ($timesheet->project_manager_approved_hrs): ?>
                    <small>· <?= h($timesheet->project_manager_approved_hrs) ?>h approved</small>
                <?php endif; ?>
                <?php if (!empty($timesheet->project_manager_comment)): ?>
                    <div><em><?= nl2br(h($timesheet->project_manager_comment))</em</div>
                <?php endif; ?>
           </td>
       </tr>

        <tr>
            <th>Status</th>
            <td><?= h($timesheet->timesheet_status) ?> · <?= h($timesheet->timesheet_comment ?? '—')</td>
       </tr>
   </table>

    <?php if ($canApproveAsRm): ?>
        <div class="ts-approval-block">
            <h4>Reporting Manager Action</h4>
            <?= $this->Form->create(null, ['url' => ['action' => 'approve', $timesheet->id]]) ?>
            <?= $this->Form->hidden('role', ['value' => 'rm']) ?>
            <?= $this->Form->control('comment', ['label' => 'Comment', 'type' => 'textarea', 'required' => false]) ?>
            <button type="submit" name="action" value="Approved" class="ts-approve-btn">Approve</button>
            <button type="submit" name="action" value="Rejected" class="ts-reject-btn">Reject</button>
            <?= $this->Form->end() ?>
       </div>
    <?php endif; ?>

    <?php if ($canApproveAsPm): ?>
        <div class="ts-approval-block">
            <h4>Project Manager Action</h4>
            <?= $this->Form->create(null, ['url' => ['action' => 'approve', $timesheet->id]]) ?>
            <?= $this->Form->hidden('role', ['value' => 'pm']) ?>
            <?= $this->Form->control('comment', ['label' => 'Comment', 'type' => 'textarea', 'required' => false]) ?>
            <button type="submit" name="action" value="Approved" class="ts-approve-btn">Approve</button>
            <button type="submit" name="action" value="Rejected" class="ts-reject-btn">Reject</button>
            <?= $this->Form->end() ?>
       </div>
    <?php endif; ?>
</div>
