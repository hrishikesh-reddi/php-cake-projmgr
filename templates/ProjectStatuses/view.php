<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProjectStatus $projectStatus
 */
$this->assign('title', h($projectStatus->status_tx));
?>
<div class="project-statuses view content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3><?= h($projectStatus->status_tx) ?></h3>
        <div class="actions">
            <?= $this->Html->link('Edit', ['action' => 'edit', $projectStatus->id], ['class' => 'button']) ?>
            <?= $this->Html->link('All Project Statuses', ['action' => 'index'], ['class' => 'button secondary']) ?>
        </div>
    </div>

    <table class="vertical-table">
        <tr><th>ID</th><td><?= $projectStatus->id ?></td></tr>
        <tr><th>Status</th><td><?= h($projectStatus->status_tx) ?></td></tr>
        <tr><th>Active</th><td><?= $projectStatus->is_active_yn ? 'Yes' : 'No' ?></td></tr>
        <tr><th>Created</th><td><?= h($projectStatus->dt_created) ?></td></tr>
    </table>
</div>