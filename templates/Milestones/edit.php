<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Milestone $milestone
 */
$this->assign('title', 'Edit Milestone: ' . h($milestone->title_tx));
?>
<div class="milestones form content">
    <h3>Edit Milestone: <?= h($milestone->title_tx) ?></h3>
    <?= $this->Form->create($milestone) ?>
    <fieldset>
        <?= $this->Form->control('project_id_nm',      ['label' => 'Project *', 'options' => $projects]) ?>
        <?= $this->Form->control('title_tx',           ['label' => 'Title *']) ?>
        <?= $this->Form->control('milestone_type',     ['label' => 'Type', 'options' => ['DELIVERY' => 'DELIVERY', 'FINANCIAL' => 'FINANCIAL'], 'empty' => '-- Select Type --']) ?>
        <?= $this->Form->control('parent_milestone_id',['label' => 'Parent Milestone', 'options' => $parents, 'empty' => '-- Select Parent --']) ?>
        <?= $this->Form->control('status',             ['label' => 'Status', 'options' => ['New', 'In Progress', 'Completed', 'On Hold'], 'empty' => '-- Select Status --']) ?>
        <?= $this->Form->control('percent_complete_nm',['label' => 'Percent Complete']) ?>
        <?= $this->Form->control('description_tx',     ['type' => 'textarea', 'rows' => 3]) ?>
        <?= $this->Form->control('start_date_dt',      ['type' => 'date']) ?>
        <?= $this->Form->control('end_date_dt',        ['type' => 'date']) ?>
        <?= $this->Form->control('actual_start_date_dt', ['type' => 'date']) ?>
        <?= $this->Form->control('actual_end_date_dt',   ['type' => 'date']) ?>
        <?= $this->Form->control('assigned_to',        ['label' => 'Assigned To (ID)']) ?>
        <?= $this->Form->control('duration',           ['label' => 'Duration (days)']) ?>
        <?= $this->Form->control('currency',           ['label' => 'Currency']) ?>
        <?= $this->Form->control('billable_amount_nm', ['label' => 'Billable Amount']) ?>
        <?= $this->Form->control('comments',           ['type' => 'textarea', 'rows' => 2]) ?>
    </fieldset>
    <div class="form-actions">
        <?= $this->Form->button('Save Changes', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'view', $milestone->id], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>