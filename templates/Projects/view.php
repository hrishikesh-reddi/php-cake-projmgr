<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Project $project
 */
$this->assign('title', h($project->name));
?>
<?php $this->append('css'); ?>
.badge { display:inline-block; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold; color:#fff; white-space:nowrap; }
.badge-green { background:#2e7d32; }
.badge-amber { background:#f9a825; color:#333; }
.badge-red   { background:#c62828; }
.badge-grey  { background:#757575; }
.budget-bar { height: 24px; border-radius: 4px; background: #e0e0e0; overflow: hidden; position: relative; }
.budget-bar > div { height: 100%; transition: width 0.3s; }
.budget-on-track { background: #2e7d32; }
.budget-at-risk  { background: #f9a825; }
.budget-over     { background: #c62828; animation: pulse-red 1.5s infinite; }
@keyframes pulse-red { 0%,100%{opacity:1} 50%{opacity:0.6} }
.budget-bar-label { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; color: #222; text-shadow: 0 0 2px #fff; }
<?php $this->end(); ?>
<?php
$badge = $project->effort_badge;
$ratio = $project->effort_ratio;
$status = $project->effort_status;
$barWidth = $ratio === null ? 0 : min(100, (int)round($ratio * 100));
$barClass = match ($status) {
    'OVER'     => 'budget-over',
    'AT RISK'  => 'budget-at-risk',
    'ON TRACK' => 'budget-on-track',
    default    => '',
};
?>
<div class="projects view content">
    <div class="page-header">
        <h3><?= h($project->name) ?> <small><?= h($project->short_name) ?></small></h3>
        <div class="actions">
            <?= $this->Html->link('Edit',   ['action' => 'edit', $project->id],   ['class' => 'button']) ?>
            <?= $this->Html->link('Status', ['action' => 'status', $project->id], ['class' => 'button secondary']) ?>
            <?= $this->Html->link('All Projects', ['action' => 'index'],           ['class' => 'button secondary']) ?>
       </div>
   </div>

    <table class="vertical-table">
        <tr><th>ID</th><td><?= $project->id</td</tr>
        <tr><th>Code</th><td><?= h($project->project_code)</td</tr>
        <tr><th>Status</th><td><?= h($project->project_status->status_tx ?? '\u2014')</td</tr>
        <tr><th>Type</th><td><?= h($project->type_obj->type_tx ?? '\u2014')</td</tr>
        <tr><th>Project Manager</th><td><?= h($project->manager_obj->display_name_tx ?? '\u2014')</td</tr>
        <tr><th>Account Manager</th><td><?= h($project->account_mgr_obj->display_name_tx ?? '\u2014')</td</tr>
        <tr><th>Start Date</th><td><?= h($project->start_date)</td</tr>
        <tr><th>End Date</th><td><?= h($project->end_date)</td</tr>
        <tr><th>Budget</th><td><?= h($project->currency) ?> <?= number_format((float)$project->budget, 2)</td</tr>
        <tr><th>Estimated Hours</th><td><?= h($project->estimated_hours ?: '\u2014')</td</tr>
        <tr>
            <th>Budget Status</th>
            <td>
                <span class="<?= $badge['class'] ?>"><?= h($badge['label'])</span>
                <?php if ($ratio !== null): ?>
                    (ratio <?= h($ratio) ?> \u2014 <?= (int)$barWidth ?>% of estimated hours used)
                <?php else: ?>
                    (no estimated hours set)
                <?php endif; ?>
                <?php if ($ratio !== null): ?>
                <div class="budget-bar" style="margin-top:6px; max-width:420px;">
                    <div class="<?= $barClass ?>" style="width: <?= $barWidth ?>%</div>
                    <div class="budget-bar-label"><?= $barWidth ?>%</div>
               </div>
                <?php endif; ?>
           </td>
       </tr>
        <tr><th</td</tr>
        <tr><th>Description</th><td><?= nl2br(h($project->description))</td</tr>
        <tr><th>Scope</th><td><?= nl2br(h($project->scope))</td</tr>
   </table>

    <?php if (empty($project->tasks)): ?>
    <p>No tasks yet. <?= $this->Html->link('+ Add the first task',
        ['controller' => 'Tasks', 'action' => 'add', '?' => ['project_id' => $project->id]])</p>
    <?php endif; ?>

    <?php if (!empty($project->tasks)): ?>
    <h4>Tasks (<?= count($project->tasks) ?>)
        <?= $this->Html->link(
            '+ Add Task',
            ['controller' => 'Tasks', 'action' => 'add', '?' => ['project_id' => $project->id]],
            ['class' => 'button small']
        ) ?>
   </h4>
    <table>
        <thead>
            <tr><th>Task</th><th>Status</th><th>Completion</th><th>Effort</th><th>Due</th><th</th</tr>
       </thead>
        <tbody>
            <?php foreach ($project->tasks as $task): ?>
            <?php $tBadge = $task->effort_badge; ?>
            <tr>
                <td><?= h($task->task_name_tx)</td>
                <td><?= h($task->task_status->status_tx ?? '\u2014')</td>
                <td><?= $task->completion ?>%</td>
                <td><span class="<?= $tBadge['class'] ?>"><?= h($tBadge['label'])</span</td>
                <td><?= h($task->due_date_dt)</td>
                <td><?= $this->Html->link('View', ['controller' => 'Tasks', 'action' => 'view', $task->id])</td>
           </tr>
            <?php endforeach; ?>
       </tbody>
   </table>
    <?php endif; ?>
</div>
