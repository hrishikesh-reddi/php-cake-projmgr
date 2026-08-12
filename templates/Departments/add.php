<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Department $department
 */
$this->assign('title', 'New Department');
?>
<div class="departments form content">
    <?= $this->element('master_nav') ?>
    <h3>Create Department</h3>
    <?= $this->Form->create($department) ?>
    <fieldset>
        <legend>Department Details</legend>
        <?= $this->Form->control('name_tx', ['label' => 'Name *']) ?>
        <?= $this->Form->control('is_active_yn', ['type' => 'checkbox', 'label' => 'Active']) ?>
    </fieldset>

    <div class="form-actions">
        <?= $this->Form->button('Create Department', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>