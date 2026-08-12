<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $divisions
 */
$this->assign('title', 'Divisions');
?>
<div class="divisions index content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3>Divisions</h3>
        <?= $this->Html->link('+ New Division', ['action' => 'add'], ['class' => 'button float-right']) ?>
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
            <?php foreach ($divisions as $division): ?>
            <tr>
                <td><?= $division->id ?></td>
                <td><?= h($division->name_tx) ?></td>
                <td><?= $division->is_active_yn ? 'Yes' : 'No' ?></td>
                <td class="actions">
                    <?= $this->Html->link('View', ['action' => 'view', $division->id]) ?>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $division->id]) ?>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $division->id],
                        ['confirm' => 'Are you sure you want to delete this division?']) ?>
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