<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
$this->assign('title', 'Edit: ' . h($employee->display_name_tx));
?>
<div class="employees form content">
    <h3>Edit Employee: <?= h($employee->display_name_tx) ?></h3>
    <?= $this->Form->create($employee) ?>
    <fieldset>
        <?= $this->Form->control('employee_id',          ['label' => 'Employee ID']) ?>
        <?= $this->Form->control('display_name_tx',      ['label' => 'Full Name *']) ?>
        <?= $this->Form->control('email_tx',             ['label' => 'Email *', 'type' => 'email']) ?>
        <?= $this->Form->control('password_tx',          ['label' => 'New Password (leave blank to keep current)', 'type' => 'password', 'required' => false]) ?>
        <?= $this->Form->control('mobile_tx',            ['label' => 'Mobile']) ?>
        <?= $this->Form->control('designation',          ['label' => 'Designation']) ?>
        <?= $this->Form->control('primary_skill',        ['label' => 'Primary Skill']) ?>
        <?= $this->Form->control('joined_on',            ['label' => 'Joining Date', 'type' => 'date']) ?>
        <?= $this->Form->control('reporting_manager_nm', ['label' => 'Reporting Manager', 'options' => $managers]) ?>
        <?= $this->Form->control('activate_yn_nm',       ['label' => 'Active', 'type' => 'checkbox']) ?>
    </fieldset>
    <div class="form-actions">
        <?= $this->Form->button('Save Changes', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'view', $employee->id], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
