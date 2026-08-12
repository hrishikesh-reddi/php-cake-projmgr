<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $projectStatuses
 */
$this->assign('title', 'Project Statuses');
?>
<div class="project-statuses index content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3>Project Statuses</h3>
        <?= $this->Html->link('+ New Project Status', ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Active</th>
                <th>Created</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projectStatuses as $projectStatus): ?>
            <tr>
                <td><?= $projectStatus->id ?></td>
                <td><?= h($projectStatus->status_tx) ?></td>
                <td><?= $projectStatus->is_active_yn ? 'Yes' : 'No' ?></td>
                <td><?= h($projectStatus->dt_created) ?></td>
                <td class="actions">
                    <?= $this->Html->link('View', ['action' => 'view', $projectStatus->id]) ?>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $projectStatus->id]) ?>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $projectStatus->id],
                        ['confirm' => 'Are you sure you want to delete this project status?']) ?>
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