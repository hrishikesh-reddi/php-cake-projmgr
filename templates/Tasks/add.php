<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
$this->assign('title', 'New Task');
?>
<div class="tasks form content">
    <h3>Create Task</h3>
    <?= $this->Form->create($task) ?>
    <fieldset>
        <legend>Task Details</legend>
        <?= $this->Form->control('task_name_tx',       ['label' => 'Task Name *']) ?>
        <?= $this->Form->control('description_tx',     ['type' => 'textarea', 'rows' => 3, 'label' => 'Description']) ?>
        <?= $this->Form->control('project_id_nm',      ['label' => 'Project *', 'options' => $projects, 'empty' => '-- Select Project --']) ?>
        <?= $this->Form->control('milestone_id_nm',    ['label' => 'Milestone', 'options' => $milestones, 'empty' => '-- Select Milestone --']) ?>
        <?= $this->Form->control('task_type_nm',       ['label' => 'Task Type', 'options' => $types, 'empty' => '-- Select Type --']) ?>
        <?= $this->Form->control('task_status_nm',     ['label' => 'Status', 'options' => $statuses, 'empty' => '-- Select Status --']) ?>
        <?= $this->Form->control('created_by_nm',      ['label' => 'Assigned To *', 'options' => $employees, 'empty' => '-- Select Employee --']) ?>
        <?= $this->Form->control('start_date_dt',      ['type' => 'date', 'label' => 'Start Date']) ?>
        <?= $this->Form->control('due_date_dt',        ['type' => 'date', 'label' => 'Due Date']) ?>
        <?= $this->Form->control('estimated_hours_nm', ['label' => 'Estimated Hours']) ?>
        <?= $this->Form->control('revised_efforts_nm', ['label' => 'Revised Efforts']) ?>
        <?= $this->Form->control('priority_nm',        ['label' => 'Priority (1=Low, 5=High)']) ?>
        <?= $this->Form->control('comments',           ['type' => 'textarea', 'rows' => 2]) ?>
    </fieldset>

    <div class="form-actions">
        <?= $this->Form->button('Create Task', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
