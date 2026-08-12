<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Division $division
 */
$this->assign('title', h($division->name_tx));
?>
<div class="divisions view content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3><?= h($division->name_tx) ?></h3>
        <div class="actions">
            <?= $this->Html->link('Edit', ['action' => 'edit', $division->id], ['class' => 'button']) ?>
            <?= $this->Html->link('All Divisions', ['action' => 'index'], ['class' => 'button secondary']) ?>
        </div>
    </div>

    <table class="vertical-table">
        <tr><th>ID</th><td><?= $division->id ?></td></tr>
        <tr><th>Name</th><td><?= h($division->name_tx) ?></td></tr>
        <tr><th>Active</th><td><?= $division->is_active_yn ? 'Yes' : 'No' ?></td></tr>
    </table>
</div>