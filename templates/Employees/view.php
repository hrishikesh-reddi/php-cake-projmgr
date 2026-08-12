<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
$this->assign('title', h($employee->display_name_tx));
?>
<div class="employees view content">
    <div class="page-header">
        <h3><?= h($employee->display_name_tx) ?></h3>
        <div class="actions">
            <?= $this->Html->link('Edit',   ['action' => 'edit',   $employee->id], ['class' => 'button']) ?>
            <?= $this->Html->link('Status', ['action' => 'status', $employee->id], ['class' => 'button secondary']) ?>
            <?= $this->Html->link('All Employees', ['action' => 'index'],           ['class' => 'button secondary']) ?>
        </div>
    </div>

    <table class="vertical-table">
        <tr><th>ID</th><td><?= $employee->id ?></td></tr>
        <tr><th>Employee ID</th><td><?= h($employee->employee_id) ?></td></tr>
        <tr><th>Email</th><td><?= h($employee->email_tx) ?></td></tr>
        <tr><th>Mobile</th><td><?= h($employee->mobile_tx) ?></td></tr>
        <tr><th>Designation</th><td><?= h($employee->designation) ?></td></tr>
        <tr><th>Primary Skill</th><td><?= h($employee->primary_skill) ?></td></tr>
        <tr><th>Joined On</th><td><?= h($employee->joined_on) ?></td></tr>
        <tr><th>Reporting To</th><td><?= h($employee->reporting_manager->display_name_tx ?? '—') ?></td></tr>
        <tr><th>Active</th><td><?= $employee->activate_yn_nm ? 'Yes' : 'No' ?></td></tr>
    </table>

    <?php if (!empty($employee->project_resources)): ?>
    <h4>Projects Assigned</h4>
    <table>
        <thead><tr><th>Project</th><th>Role</th><th>Start</th><th>End</th></tr></thead>
        <tbody>
            <?php foreach ($employee->project_resources as $res): ?>
            <tr>
                <td><?= h($res->project->name ?? '—') ?></td>
                <td><?= h($res->resource_type_title) ?></td>
                <td><?= h($res->start_date_dt) ?></td>
                <td><?= h($res->end_date_dt) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
