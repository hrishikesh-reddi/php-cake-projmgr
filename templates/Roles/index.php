<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $roles
 */
$this->assign('title', 'Roles');
?>
<div class="roles index content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3>Roles</h3>
        <?= $this->Html->link('+ New Role', ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Short Name</th>
                <th>Active</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $role): ?>
            <tr>
                <td><?= $role->id ?></td>
                <td><?= h($role->name_tx) ?></td>
                <td><?= h($role->short_name_tx) ?></td>
                <td><?= $role->is_active_nm ? 'Yes' : 'No' ?></td>
                <td class="actions">
                    <?= $this->Html->link('View', ['action' => 'view', $role->id]) ?>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $role->id]) ?>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $role->id],
                        ['confirm' => 'Are you sure you want to delete this role?']) ?>
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