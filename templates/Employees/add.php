<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
$this->assign('title', 'New Employee');
?>
<div class="employees form content">
    <h3>Add Employee</h3>
    <?= $this->Form->create($employee) ?>
    <fieldset>
        <legend>Employee Details</legend>
        <?= $this->Form->control('employee_id',          ['label' => 'Employee ID']) ?>
        <?= $this->Form->control('display_name_tx',      ['label' => 'Full Name *']) ?>
        <?= $this->Form->control('email_tx',             ['label' => 'Email *', 'type' => 'email']) ?>
        <?= $this->Form->control('password_tx',          ['label' => 'Password *', 'type' => 'password']) ?>
        <?= $this->Form->control('mobile_tx',            ['label' => 'Mobile']) ?>
        <?= $this->Form->control('designation',          ['label' => 'Designation']) ?>
        <?= $this->Form->control('primary_skill',        ['label' => 'Primary Skill']) ?>
        <?= $this->Form->control('joined_on',            ['label' => 'Joining Date', 'type' => 'date']) ?>
        <?= $this->Form->control('reporting_manager_nm', ['label' => 'Reporting Manager', 'options' => $managers, 'empty' => '-- Select Manager --']) ?>
    </fieldset>
    <div class="form-actions">
        <?= $this->Form->button('Add Employee', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
