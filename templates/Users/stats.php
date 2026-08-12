<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'User Statistics');
?>
<div class="users stats content">
    <div class="page-header">
        <h3>User Statistics</h3>
        <?= $this->Html->link('All users', ['action' => 'index'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <tr><th>Total users</th><td><?= h($totalUsers) ?></td></tr>
        <tr><th>Active users</th><td><?= h($activeUsers) ?></td></tr>
        <tr><th>Users with failed logins</th><td><?= h($failedLogins) ?></td></tr>
        <tr><th>Users who never logged in</th><td><?= h($neverLoggedIn) ?></td></tr>
    </table>
</div>