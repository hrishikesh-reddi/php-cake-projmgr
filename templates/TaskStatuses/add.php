<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TaskStatus $taskStatus
 */
$this->assign('title', 'New Task Status');
?>
<div class="task-statuses form content">
    <?= $this->element('master_nav') ?>
    <h3>Create Task Status</h3>
    <?= $this->Form->create($taskStatus) ?>
    <fieldset>
        <legend>Task Status Details</legend>
        <?= $this->Form->control('status_tx', ['label' => 'Status *']) ?>
        <?= $this->Form->control('status_value_tx', ['label' => 'Status Value *']) ?>
        <?= $this->Form->control('is_active_nm', ['type' => 'checkbox', 'label' => 'Active']) ?>
    </fieldset>

    <div class="form-actions">
        <?= $this->Form->button('Create Task Status', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>