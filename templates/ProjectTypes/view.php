<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProjectType $projectType
 */
$this->assign('title', h($projectType->type_tx));
?>
<div class="project-types view content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3><?= h($projectType->type_tx) ?></h3>
        <div class="actions">
            <?= $this->Html->link('Edit', ['action' => 'edit', $projectType->id], ['class' => 'button']) ?>
            <?= $this->Html->link('All Project Types', ['action' => 'index'], ['class' => 'button secondary']) ?>
        </div>
    </div>

    <table class="vertical-table">
        <tr><th>ID</th><td><?= $projectType->id ?></td></tr>
        <tr><th>Type</th><td><?= h($projectType->type_tx) ?></td></tr>
        <tr><th>Active</th><td><?= $projectType->is_active_yn ? 'Yes' : 'No' ?></td></tr>
    </table>
</div>