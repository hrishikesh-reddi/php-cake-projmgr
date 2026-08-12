<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $taskTypes
 */
$this->assign('title', 'Task Types');
?>
<div class="task-types index content">
    <?= $this->element('master_nav') ?>
    <div class="page-header">
        <h3>Task Types</h3>
        <?= $this->Html->link('+ New Task Type', ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Type Name</th>
                <th>Active</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($taskTypes as $taskType): ?>
            <tr>
                <td><?= $taskType->id ?></td>
                <td><?= h($taskType->task_type_name_tx) ?></td>
                <td><?= $taskType->is_active_nm ? 'Yes' : 'No' ?></td>
                <td class="actions">
                    <?= $this->Html->link('View', ['action' => 'view', $taskType->id]) ?>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $taskType->id]) ?>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $taskType->id],
                        ['confirm' => 'Are you sure you want to delete this task type?']) ?>
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