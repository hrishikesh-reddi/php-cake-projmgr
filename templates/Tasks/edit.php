<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
$this->assign('title', 'Edit Task: ' . h($task->task_name_tx));
?>
<div class="tasks form content">
    <h3>Edit Task: <?= h($task->task_name_tx) ?></h3>
    <?= $this->Form->create($task) ?>
    <fieldset>
        <?= $this->Form->control('task_name_tx',       ['label' => 'Task Name *']) ?>
        <?= $this->Form->control('description_tx',     ['type' => 'textarea', 'rows' => 3]) ?>
        <?= $this->Form->control('project_id_nm',      ['label' => 'Project', 'options' => $projects]) ?>
        <?= $this->Form->control('milestone_id_nm',    ['label' => 'Milestone', 'options' => $milestones, 'empty' => '-- Select Milestone --']) ?>
        <?= $this->Form->control('task_type_nm',       ['label' => 'Type', 'options' => $types]) ?>
        <?= $this->Form->control('task_status_nm',     ['label' => 'Status', 'options' => $statuses]) ?>
        <?= $this->Form->control('created_by_nm',      ['label' => 'Assigned To', 'options' => $employees]) ?>
        <?= $this->Form->control('start_date_dt',      ['type' => 'date']) ?>
        <?= $this->Form->control('due_date_dt',        ['type' => 'date']) ?>
        <?= $this->Form->control('estimated_hours_nm', ['label' => 'Estimated Hours']) ?>
        <?= $this->Form->control('revised_efforts_nm', ['label' => 'Revised Efforts']) ?>
        <?= $this->Form->control('spent_hours_nm',     ['label' => 'Spent Hours']) ?>
        <?= $this->Form->control('completion',         ['label' => 'Completion (%)']) ?>
        <?= $this->Form->control('priority_nm',        ['label' => 'Priority']) ?>
        <?= $this->Form->control('comments',           ['type' => 'textarea', 'rows' => 2]) ?>
    </fieldset>
    <div class="form-actions">
        <?= $this->Form->button('Save Changes', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'view', $task->id], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
