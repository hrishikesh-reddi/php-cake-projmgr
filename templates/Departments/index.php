<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $departments
 */
$this->assign('title', 'Departments');
?>
<div class="departments index content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3>Departments</h3>
        <?= $this->Html->link('+ New Department', ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Active</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($departments as $department): ?>
            <tr>
                <td><?= $department->id ?></td>
                <td><?= h($department->name_tx) ?></td>
                <td><?= $department->is_active_yn ? 'Yes' : 'No' ?></td>
                <td class="actions">
                    <?= $this->Html->link('View', ['action' => 'view', $department->id]) ?>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $department->id]) ?>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $department->id],
                        ['confirm' => 'Are you sure you want to delete this department?']) ?>
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