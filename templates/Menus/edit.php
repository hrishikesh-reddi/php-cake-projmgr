<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Menu $menu
 */
$this->assign('title', 'Edit Menu Entry: ' . h($menu->label));
?>
<div class="menus form content">
    <?= $this->element('master_nav') ?>
    <h3>Edit Menu Entry: <?= h($menu->label) ?></h3>
    <?= $this->Form->create($menu) ?>
    <fieldset>
        <legend>Menu Details</legend>
        <?= $this->Form->control('label', ['label' => 'Label']) ?>
        <?= $this->Form->control('action', ['label' => 'Action']) ?>
        <?= $this->Form->control('icon', ['label' => 'Icon']) ?>
        <?= $this->Form->control('class_name', ['label' => 'Class Name']) ?>
        <?= $this->Form->control('menu_type_id', ['label' => 'Menu Type ID']) ?>
        <?= $this->Form->control('ref_id', ['label' => 'Ref ID']) ?>
        <?= $this->Form->control('action_id', ['label' => 'Action ID']) ?>
        <?= $this->Form->control('is_active', ['type' => 'checkbox', 'label' => 'Active']) ?>
    </fieldset>

    <div class="form-actions">
        <?= $this->Form->button('Save Changes', ['class' => 'button']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'view', $menu->id], ['class' => 'button secondary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>