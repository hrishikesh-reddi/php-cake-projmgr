<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Menu $menu
 */
$this->assign('title', h($menu->label));
?>
<div class="menus view content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3><?= h($menu->label) ?></h3>
        <div class="actions">
            <?= $this->Html->link('Edit', ['action' => 'edit', $menu->id], ['class' => 'button']) ?>
            <?= $this->Html->link('All Menus', ['action' => 'index'], ['class' => 'button secondary']) ?>
        </div>
    </div>

    <table class="vertical-table">
        <tr><th>ID</th><td><?= $menu->id ?></td></tr>
        <tr><th>Label</th><td><?= h($menu->label) ?></td></tr>
        <tr><th>Action</th><td><?= h($menu->action) ?></td></tr>
        <tr><th>Icon</th><td><?= h($menu->icon) ?></td></tr>
        <tr><th>Class Name</th><td><?= h($menu->class_name) ?></td></tr>
        <tr><th>Menu Type ID</th><td><?= h($menu->menu_type_id) ?></td></tr>
        <tr><th>Ref ID</th><td><?= h($menu->ref_id) ?></td></tr>
        <tr><th>Action ID</th><td><?= h($menu->action_id) ?></td></tr>
        <tr><th>Active</th><td><?= $menu->is_active ? 'Yes' : 'No' ?></td></tr>
    </table>
</div>