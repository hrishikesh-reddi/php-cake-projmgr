<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProjectStatus $projectStatus
 */
$this->assign('title', 'Edit Project Status: ' . h($projectStatus->status_tx));
?>
<div class="project-statuses form content">
    <?= $this->element('master_nav') ?>
    <h3>Edit Project Status: <?= h($projectStatus->status_tx) ?></h3>
    <?= $this->Form->create($projectStatus) ?>
    <fieldset>
        <legend>Project Status Details</legend>
        <?= $this->Form->control('status_tx', ['label' => 'Status *']) ?>
        <?= $this->Form->control('is_active_yn', ['type' => 'checkbox', 'label' => 'Active']) ?>
    </fieldset>

    <div class="form-actions">
        <?= $this->Form->button('Save Changes', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'view', $projectStatus->id], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>