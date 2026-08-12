<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TaskType $taskType
 */
$this->assign('title', 'New Task Type');
?>
<div class="task-types form content">
    <?= $this->element('master_nav') ?>
    <h3>Create Task Type</h3>
    <?= $this->Form->create($taskType) ?>
    <fieldset>
        <legend>Task Type Details</legend>
        <?= $this->Form->control('task_type_name_tx', ['label' => 'Type Name *']) ?>
        <?= $this->Form->control('is_active_nm', ['type' => 'checkbox', 'label' => 'Active']) ?>
    </fieldset>

    <div class="form-actions">
        <?= $this->Form->button('Create Task Type', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>