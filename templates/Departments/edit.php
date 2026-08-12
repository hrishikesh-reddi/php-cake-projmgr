<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Department $department
 */
$this->assign('title', 'Edit Department: ' . h($department->name_tx));
?>
<div class="departments form content">
    <?= $this->element('master_nav') ?>
    <h3>Edit Department: <?= h($department->name_tx) ?></h3>
    <?= $this->Form->create($department) ?>
    <fieldset>
        <legend>Department Details</legend>
        <?= $this->Form->control('name_tx', ['label' => 'Name *']) ?>
        <?= $this->Form->control('is_active_yn', ['type' => 'checkbox', 'label' => 'Active']) ?>
    </fieldset>

    <div class="form-actions">
        <?= $this->Form->button('Save Changes', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'view', $department->id], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>