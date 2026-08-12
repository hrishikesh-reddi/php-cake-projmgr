<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $employees
 */
$this->assign('title', 'Employees');
?>
<div class="employees index content">
    <div class="page-header">
        <h3>Employees</h3>
        <?= $this->Html->link('+ New Employee', ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Emp ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Designation</th>
                <th>Reporting To</th>
                <th>Active</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $emp): ?>
            <tr>
                <td><?= $emp->id ?></td>
                <td><?= h($emp->employee_id) ?></td>
                <td><?= h($emp->display_name_tx) ?></td>
                <td><?= h($emp->email_tx) ?></td>
                <td><?= h($emp->designation) ?></td>
                <td><?= h($emp->reporting_manager->display_name_tx ?? '—') ?></td>
                <td><?= $emp->activate_yn_nm ? 'Yes' : 'No' ?></td>
                <td class="actions">
                    <?= $this->Html->link('View',   ['action' => 'view',   $emp->id]) ?>
                    <?= $this->Html->link('Edit',   ['action' => 'edit',   $emp->id]) ?>
                    <?= $this->Html->link('Status', ['action' => 'status', $emp->id]) ?>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $emp->id],
                        ['confirm' => 'Delete this employee?']) ?>
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
