<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
$this->assign('title', 'Status: ' . h($employee->display_name_tx));
?>
<div class="employees status content">
    <h3>Employee Status: <?= h($employee->display_name_tx) ?></h3>
    <table class="vertical-table">
        <tr><th>Active</th><td><strong><?= $employee->activate_yn_nm ? 'Active' : 'Inactive' ?></strong></td></tr>
        <tr><th>Designation</th><td><?= h($employee->designation) ?></td></tr>
        <tr><th>Email</th><td><?= h($employee->email_tx) ?></td></tr>
        <tr><th>Reporting To</th><td><?= h($employee->reporting_manager->display_name_tx ?? '—') ?></td></tr>
    </table>
    <div class="actions">
        <?= $this->Html->link('Full Profile', ['action' => 'view', $employee->id], ['class' => 'button']) ?>
    </div>
</div>
