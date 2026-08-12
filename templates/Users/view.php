<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'User — ' . h($user->display_name_tx));
?>
<div class="users view content">
    <div class="page-header">
        <h3><?= h($user->display_name_tx) ?></h3>
        <?= $this->Html->link('Back to users', ['action' => 'index'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <tr><th>ID</th><td><?= h($user->id) ?></td></tr>
        <tr><th>Emp ID</th><td><?= h($user->employee_id ?? '—') ?></td></tr>
        <tr><th>Name</th><td><?= h($user->display_name_tx) ?></td></tr>
        <tr><th>Email</th><td><?= h($user->email_tx) ?></td></tr>
        <tr><th>Mobile</th><td><?= h($user->mobile_tx ?? '—') ?></td></tr>
        <tr><th>Active</th><td><?= $user->activate_yn_nm ? 'Yes' : 'No' ?></td></tr>
        <tr><th>Last Login</th><td><?= $user->last_login_dt ? h($user->last_login_dt->i18nFormat('yyyy-MM-dd HH:mm')) : 'Never' ?></td></tr>
        <tr><th>Failed Logins</th><td><?= (int)$user->login_failures_nm ?></td></tr>
        <tr><th>Last Login Failure</th><td><?= $user->last_login_failure_dt ? h($user->last_login_failure_dt->i18nFormat('yyyy-MM-dd HH:mm')) : '—' ?></td></tr>
        <tr><th>Joined</th><td><?= $user->joined_on ? h($user->joined_on) : '—' ?></td></tr>
    </table>
</div>