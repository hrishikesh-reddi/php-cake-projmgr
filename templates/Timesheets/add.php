<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Timesheet $timesheet
 */
$this->assign('title', 'New Timesheet');
?>
<style>
    .ts-week-pill {
        display: inline-block;
        padding: 4px 12px;
        background: #e0e7ff;
        color: #3730a3;
        border-radius: 999px;
        font-weight: 600;
        font-size: 13px;
        margin-left: 8px;
    }
</style>

<div class="timesheets form content">
    <h3>
        Submit Timesheet
        <span class="ts-week-pill">Week <?= h((int)date('W')) ?> / <?= h((int)date('Y'))</span>
   </h3>

    <?= $this->Form->create($timesheet) ?>
    <fieldset>
        <legend>Timesheet Details</legend>

        <?= $this->Form->control('user_id', [
            'label'    => 'User *',
            'options'  => $employees,
            'empty'    => '-- Select User --',
            'default'  => $timesheet->user_id,
        ]) ?>
        <?= $this->Form->control('project_id', [
            'label'   => 'Project *',
            'options' => $projects,
            'empty'   => '-- Select Project --',
        ]) ?>
        <?= $this->Form->control('task_id', [
            'label'   => 'Task *',
            'options' => $tasks,
            'empty'   => '-- Select Task --',
        ]) ?>
        <?= $this->Form->control('approved_hours', [
            'label' => 'Hours *',
            'type'  => 'number',
            'step'  => '0.25',
            'min'   => 0,
            'max'   => 168,
        ]) ?>
        <?= $this->Form->control('is_billable', [
            'label' => 'Billable?',
            'type'  => 'checkbox',
        ]) ?>
        <?= $this->Form->control('user_comments', [
            'label' => 'Comments',
            'type'  => 'textarea',
            'rows'  => 3,
        ]) ?>

        <?= $this->Form->hidden('year',         ['value' => (int)date('Y')]) ?>
        <?= $this->Form->hidden('week_number',  ['value' => (int)date('W')]) ?>
        <?= $this->Form->hidden('timesheet_status', ['value' => 0]) ?>
   </fieldset>

    <div class="form-actions">
        <?= $this->Form->button('Submit Timesheet', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'button secondary']) ?>
   </div>
    <?= $this->Form->end() ?>
</div>
