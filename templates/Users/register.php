<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Create account');
?>
<div class="users register content">
    <div class="page-header">
        <h3>Create an account</h3>
        <?= $this->Html->link('Back to sign in', ['action' => 'login'], ['class' => 'button float-right']) ?>
    </div>

    <?= $this->Form->create($user, ['url' => ['action' => 'register']]) ?>
    <?= $this->Form->control('display_name_tx', ['label' => 'Full Name', 'required' => true, 'autofocus' => true]) ?>
    <?= $this->Form->control('email_tx', ['label' => 'Email', 'type' => 'email', 'required' => true]) ?>
    <?= $this->Form->control('mobile_tx', ['label' => 'Mobile', 'type' => 'text']) ?>
    <?= $this->Form->control('password_tx', ['label' => 'Password', 'type' => 'password', 'required' => true]) ?>
    <?= $this->Form->control('confirm_password', ['label' => 'Confirm Password', 'type' => 'password', 'required' => true]) ?>
    <?= $this->Form->button('Create account', ['class' => 'button']) ?>
    <?= $this->Form->end() ?>
</div>