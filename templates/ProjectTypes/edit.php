<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProjectType $projectType
 */
$this->assign('title', 'Edit Project Type: ' . h($projectType->type_tx));
?>
<div class="project-types form content">
    <?= $this->element('master_nav') ?>
    <h3>Edit Project Type: <?= h($projectType->type_tx) ?></h3>
    <?= $this->Form->create($projectType) ?>
    <fieldset>
        <legend>Project Type Details</legend>
        <?= $this->Form->control('type_tx', ['label' => 'Type *']) ?>
        <?= $this->Form->control('is_active_yn', ['type' => 'checkbox', 'label' => 'Active']) ?>
    </fieldset>

    <div class="form-actions">
        <?= $this->Form->button('Save Changes', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'view', $projectType->id], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>