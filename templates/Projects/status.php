<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Project $project
 */
$this->assign('title', 'Status: ' . h($project->name));
?>
<div class="projects status content">
    <h3>Project Status: <?= h($project->name) ?></h3>

    <table class="vertical-table">
        <tr><th>Status</th><td><strong><?= h($project->project_status->status_tx ?? 'Unknown') ?></strong></td></tr>
        <tr><th>Progress</th><td><?= h($project->progress) ?>%</td></tr>
        <tr><th>Start Date</th><td><?= h($project->start_date) ?></td></tr>
        <tr><th>End Date</th><td><?= h($project->end_date) ?></td></tr>
    </table>

    <div class="actions">
        <?= $this->Html->link('View Full Details', ['action' => 'view', $project->id], ['class' => 'button']) ?>
        <?= $this->Html->link('Edit', ['action' => 'edit', $project->id], ['class' => 'button secondary']) ?>
    </div>
</div>
