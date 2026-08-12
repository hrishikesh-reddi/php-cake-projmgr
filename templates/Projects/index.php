<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $projects
 */
$this->assign('title', 'Projects');
?>
<div class="projects index content">
    <div class="page-header">
        <h3>Projects</h3>
        <?= $this->Html->link('+ New Project', ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th><?= $this->Paginator->sort('name', 'Project Name') ?></th>
                <th>Status</th>
                <th>Type</th>
                <th>Project Manager</th>
                <th><?= $this->Paginator->sort('start_date', 'Start') ?></th>
                <th><?= $this->Paginator->sort('end_date', 'End') ?></th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
            <tr>
                <td><?= $project->id ?></td>
                <td><?= h($project->name) ?></td>
                <td><?= h($project->project_status->status_tx ?? '—') ?></td>
                <td><?= h($project->type_obj->type_tx ?? '—') ?></td>
                <td><?= h($project->manager_obj->display_name_tx ?? '—') ?></td>
                <td><?= h($project->start_date) ?></td>
                <td><?= h($project->end_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link('View',   ['action' => 'view',   $project->id]) ?>
                    <?= $this->Html->link('Edit',   ['action' => 'edit',   $project->id]) ?>
                    <?= $this->Html->link('Status', ['action' => 'status', $project->id]) ?>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $project->id],
                        ['confirm' => 'Are you sure you want to delete this project?']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
