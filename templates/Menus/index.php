<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $menus
 */
$this->assign('title', 'Menus');
?>
<div class="menus index content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3>Menus</h3>
        <?= $this->Html->link('+ New Menu Entry', ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Label</th>
                <th>Action</th>
                <th>Icon</th>
                <th>Active</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menus as $menu): ?>
            <tr>
                <td><?= $menu->id ?></td>
                <td><?= h($menu->label) ?></td>
                <td><?= h($menu->action) ?></td>
                <td><?= h($menu->icon) ?></td>
                <td><?= $menu->is_active ? 'Yes' : 'No' ?></td>
                <td class="actions">
                    <?= $this->Html->link('View', ['action' => 'view', $menu->id]) ?>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $menu->id]) ?>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $menu->id],
                        ['confirm' => 'Are you sure you want to delete this menu entry?']) ?>
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