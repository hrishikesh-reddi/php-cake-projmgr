<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Sign in');
?>
<div class="users login content">
    <div class="page-header">
        <h3>Sign in</h3>
    </div>
    <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'login']]) ?>
    <?= $this->Form->control('email', [
        'label' => 'Email',
        'type'  => 'email',
        'required' => true,
        'autofocus' => true,
    ]) ?>
    <?= $this->Form->control('password', [
        'label' => 'Password',
        'type'  => 'password',
        'required' => true,
    ]) ?>
    <?= $this->Form->button('Sign in', ['class' => 'button']) ?>
    <?= $this->Form->end() ?>
    <p><?= $this->Html->link('Create an account', ['action' => 'register']) ?></p>
</div>