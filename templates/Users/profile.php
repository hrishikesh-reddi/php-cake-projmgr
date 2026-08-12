<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'My Profile');
?>
<div class="users profile content">
    <div class="page-header">
        <h3>My Profile</h3>
        <?= $this->Html->link('View statistics', ['action' => 'stats'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <tr><th>Emp ID</th><td><?= h($user->employee_id ?? '—') ?></td></tr>
        <tr><th>Email</th><td><?= h($user->email_tx) ?></td></tr>
        <tr><th>Last Login</th><td><?= $user->last_login_dt ? h($user->last_login_dt->i18nFormat('yyyy-MM-dd HH:mm')) : 'Never' ?></td></tr>
        <tr><th>Failed Logins</th><td><?= (int)$user->login_failures_nm ?></td></tr>
    </table>

    <h4>Update your details</h4>
    <?= $this->Form->create($user, ['url' => ['action' => 'profile']]) ?>
    <?= $this->Form->control('display_name_tx', ['label' => 'Display Name', 'required' => true]) ?>
    <?= $this->Form->control('mobile_tx', ['label' => 'Mobile', 'type' => 'text']) ?>
    <hr>
    <h4>Change password</h4>
    <?= $this->Form->control('current_password', ['label' => 'Current Password', 'type' => 'password', 'autocomplete' => 'off']) ?>
    <?= $this->Form->control('password_tx', ['label' => 'New Password', 'type' => 'password', 'autocomplete' => 'new-password']) ?>
    <?= $this->Form->control('confirm_password', ['label' => 'Confirm New Password', 'type' => 'password', 'autocomplete' => 'new-password']) ?>
    <?= $this->Form->button('Save changes', ['class' => 'button']) ?>
    <?= $this->Form->end() ?>
</div>