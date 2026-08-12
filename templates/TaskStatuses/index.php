<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $taskStatuses
 */
$this->assign('title', 'Task Statuses');
?>
<div class="task-statuses index content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3>Task Statuses</h3>
        <?= $this->Html->link('+ New Task Status', ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Value</th>
                <th>Active</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($taskStatuses as $taskStatus): ?>
            <tr>
                <td><?= $taskStatus->id ?></td>
                <td><?= h($taskStatus->status_tx) ?></td>
                <td><?= h($taskStatus->status_value_tx) ?></td>
                <td><?= $taskStatus->is_active_nm ? 'Yes' : 'No' ?></td>
                <td class="actions">
                    <?= $this->Html->link('View', ['action' => 'view', $taskStatus->id]) ?>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $taskStatus->id]) ?>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $taskStatus->id],
                        ['confirm' => 'Are you sure you want to delete this task status?']) ?>
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