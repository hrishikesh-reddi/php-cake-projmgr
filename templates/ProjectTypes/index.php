<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $projectTypes
 */
$this->assign('title', 'Project Types');
?>
<div class="project-types index content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3>Project Types</h3>
        <?= $this->Html->link('+ New Project Type', ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Active</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projectTypes as $projectType): ?>
            <tr>
                <td><?= $projectType->id ?></td>
                <td><?= h($projectType->type_tx) ?></td>
                <td><?= $projectType->is_active_yn ? 'Yes' : 'No' ?></td>
                <td class="actions">
                    <?= $this->Html->link('View', ['action' => 'view', $projectType->id]) ?>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $projectType->id]) ?>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $projectType->id],
                        ['confirm' => 'Are you sure you want to delete this project type?']) ?>
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