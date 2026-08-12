<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Project $project
 */
$this->assign('title', 'New Project');
?>
<div class="projects form content">
    <h3>Create Project</h3>
    <?= $this->Form->create($project) ?>
    <fieldset>
        <legend>Project Details</legend>

        <?= $this->Form->control('name',        ['label' => 'Project Name *']) ?>
        <?= $this->Form->control('short_name',  ['label' => 'Short Name *']) ?>
        <?= $this->Form->control('project_code',['label' => 'Project Code']) ?>
        <?= $this->Form->control('description', ['type' => 'textarea', 'rows' => 4]) ?>
        <?= $this->Form->control('status_id',   ['label' => 'Status', 'options' => $statuses, 'empty' => '-- Select Status --']) ?>
        <?= $this->Form->control('type_id',     ['label' => 'Project Type', 'options' => $types, 'empty' => '-- Select Type --']) ?>
        <?= $this->Form->control('project_manager', ['label' => 'Project Manager', 'options' => $managers, 'empty' => '-- Select Manager --']) ?>
        <?= $this->Form->control('account_manager', ['label' => 'Account Manager', 'options' => $managers, 'empty' => '-- Select --']) ?>
        <?= $this->Form->control('start_date',  ['type' => 'date', 'label' => 'Start Date']) ?>
        <?= $this->Form->control('end_date',    ['type' => 'date', 'label' => 'End Date']) ?>
        <?= $this->Form->control('budget',      ['label' => 'Budget']) ?>
        <?= $this->Form->control('currency',    ['label' => 'Currency', 'default' => 'USD']) ?>
        <?= $this->Form->control('scope',       ['type' => 'textarea', 'rows' => 3, 'label' => 'Scope of Work']) ?>
    </fieldset>

    <div class="form-actions">
        <?= $this->Form->button('Create Project', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
