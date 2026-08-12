<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Project $project
 */
$this->assign('title', 'Edit Project: ' . h($project->name));
?>
<div class="projects form content">
    <h3>Edit Project: <?= h($project->name) ?></h3>
    <?= $this->Form->create($project) ?>
    <fieldset>
        <legend>Project Details</legend>
        <?= $this->Form->control('name',        ['label' => 'Project Name *']) ?>
        <?= $this->Form->control('short_name',  ['label' => 'Short Name *']) ?>
        <?= $this->Form->control('project_code',['label' => 'Project Code']) ?>
        <?= $this->Form->control('description', ['type' => 'textarea', 'rows' => 4]) ?>
        <?= $this->Form->control('status_id',   ['label' => 'Status', 'options' => $statuses]) ?>
        <?= $this->Form->control('type_id',     ['label' => 'Project Type', 'options' => $types]) ?>
        <?= $this->Form->control('project_manager', ['label' => 'Project Manager', 'options' => $managers]) ?>
        <?= $this->Form->control('account_manager', ['label' => 'Account Manager', 'options' => $managers]) ?>
        <?= $this->Form->control('start_date',  ['type' => 'date']) ?>
        <?= $this->Form->control('end_date',    ['type' => 'date']) ?>
        <?= $this->Form->control('budget') ?>
        <?= $this->Form->control('currency') ?>
        <?= $this->Form->control('progress',    ['label' => 'Progress (%)']) ?>
        <?= $this->Form->control('scope',       ['type' => 'textarea', 'rows' => 3]) ?>
    </fieldset>

    <div class="form-actions">
        <?= $this->Form->button('Save Changes', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'view', $project->id], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
