<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
$this->assign('title', 'Edit Role: ' . h($role->name_tx));
?>
<div class="roles form content">
    <?= $this->element('master_nav') ?>
    <h3>Edit Role: <?= h($role->name_tx) ?></h3>
    <?= $this->Form->create($role) ?>
    <fieldset>
        <legend>Role Details</legend>
        <?= $this->Form->control('name_tx', ['label' => 'Name *']) ?>
        <?= $this->Form->control('short_name_tx', ['label' => 'Short Name']) ?>
        <?= $this->Form->control('user_role_nm', ['label' => 'User Role ID']) ?>
        <?= $this->Form->control('is_active_nm', ['type' => 'checkbox', 'label' => 'Active']) ?>
    </fieldset>

    <div class="form-actions">
        <?= $this->Form->button('Save Changes', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'view', $role->id], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>