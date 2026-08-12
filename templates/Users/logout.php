<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Signed out');
?>
<div class="users logout content">
    <div class="page-header">
        <h3>You have been signed out</h3>
    </div>
    <p>Thanks for using Geminitools. <?= $this->Html->link('Sign back in', ['action' => 'login']) ?>.</p>
</div>