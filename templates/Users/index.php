<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $users
 */
$this->assign('title', 'Users');
?>
<div class="users index content">
    <div class="page-header">
        <h3>Users</h3>
        <?= $this->Html->link('View statistics', ['action' => 'stats'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th>Emp ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Active</th>
                <th><?= $this->Paginator->sort('last_login_dt', 'Last Login') ?></th>
                <th><?= $this->Paginator->sort('login_failures_nm', 'Failed Logins') ?></th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= h($user->id) ?></td>
                <td><?= h($user->employee_id ?? '—') ?></td>
                <td><?= h($user->display_name_tx) ?></td>
                <td><?= h($user->email_tx) ?></td>
                <td><?= $user->activate_yn_nm ? 'Yes' : 'No' ?></td>
                <td><?= $user->last_login_dt ? h($user->last_login_dt->i18nFormat('yyyy-MM-dd HH:mm')) : '—' ?></td>
                <td><?= (int)$user->login_failures_nm ?></td>
                <td class="actions">
                    <?= $this->Html->link('View', ['action' => 'view', $user->id]) ?>
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