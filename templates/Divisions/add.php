<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Division $division
 */
$this->assign('title', 'New Division');
?>
<div class="divisions form content">
    <?= $this->element('master_nav') ?>
    <h3>Create Division</h3>
    <?= $this->Form->create($division) ?>
    <fieldset>
        <legend>Division Details</legend>
        <?= $this->Form->control('name_tx', ['label' => 'Name *']) ?>
        <?= $this->Form->control('is_active_yn', ['type' => 'checkbox', 'label' => 'Active']) ?>
    </fieldset>

    <div class="form-actions">
        <?= $this->Form->button('Create Division', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>