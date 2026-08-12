<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $milestones
 */
$this->assign('title', 'Milestones');
?>
<div class="milestones index content">
    <div class="page-header">
        <h3>Milestones</h3>
        <?= $this->Html->link('+ New Milestone', ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Project</th>
                <th>Type</th>
                <th>Status</th>
                <th>% Complete</th>
                <th>Start</th>
                <th>End</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($milestones as $milestone): ?>
            <tr>
                <td><?= $milestone->id ?></td>
                <td><?= h($milestone->title_tx) ?></td>
                <td><?= h($milestone->project->name ?? '—') ?></td>
                <td><?= h($milestone->milestone_type ?? '—') ?></td>
                <td><?= h($milestone->status ?? ($milestone->delivery_milestone_status ?: $milestone->financial_milestone_status ?: '—')) ?></td>
                <td><?= h($milestone->percent_complete_nm ?? 0) ?>%</td>
                <td><?= h($milestone->start_date_dt) ?></td>
                <td><?= h($milestone->end_date_dt) ?></td>
                <td class="actions">
                    <?= $this->Html->link('View',   ['action' => 'view',   $milestone->id]) ?>
                    <?= $this->Html->link('Edit',   ['action' => 'edit',   $milestone->id]) ?>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $milestone->id],
                        ['confirm' => 'Delete this milestone?']) ?>
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