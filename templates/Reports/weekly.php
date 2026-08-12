<?php
/**
 * @var \App\View\AppView $this
 * @var int $year
 * @var int $week
 * @var string $weekStart
 * @var string $weekEnd
 * @var array $kpis
 * @var array $rows
 */

$this->assign('title', sprintf('Weekly Status - Week %d, %d', $week, $year));

$prev = (new \DateTimeImmutable())->setISODate($year, $week)->modify('-7 days');
$next = (new \DateTimeImmutable())->setISODate($year, $week)->modify('+7 days');
?>
<?php $this->append('css'); ?>
<style>
.kpi-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin:18px 0 26px; }
.kpi-card { background:#fff; border:1px solid #e0e3e8; border-radius:6px; padding:16px; box-shadow:0 1px 2px rgba(0,0,0,0.04); }
.kpi-label { font-size:11px; text-transform:uppercase; letter-spacing:0.06em; color:#606c76; margin-bottom:6px; font-weight:600; }
.kpi-value { font-size:28px; font-weight:700; color:#363637; line-height:1.1; }
.kpi-sub { font-size:12px; color:#888; margin-top:4px; }
.week-bar { display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap; margin:8px 0 18px; padding:12px 14px; background:#f5f7fa; border:1px solid #e0e3e8; border-radius:6px; }
.week-bar form { display:flex; gap:8px; align-items:center; margin:0; }
.week-bar input[type=number] { width:90px; }
.week-nav { display:flex; gap:6px; }
.week-nav a { padding:4px 10px; border:1px solid #d0d4d9; border-radius:4px; text-decoration:none; color:#2f85ae; font-size:13px; }
.week-nav a:hover { background:#eff8ff; }
table.weekly-projects { font-size:13px; }
table.weekly-projects td, table.weekly-projects th { padding:8px 10px; }
.status-badge { display:inline-block; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:700; color:#fff; background:#606c76; }
.status-active { background:#2e7d32; }
.status-onhold { background:#f9a825; color:#333; }
.status-closed { background:#9e9e9e; }
.status-cancelled { background:#c62828; }
.risk-dot { display:inline-block; width:10px; height:10px; border-radius:50%; background:#c62828; margin-right:6px; vertical-align:middle; }
.risk-dot.clean { background:#2e7d32; }
.progress-bar { background:#e0e3e8; border-radius:4px; height:8px; width:120px; overflow:hidden; display:inline-block; vertical-align:middle; margin-right:6px; }
.progress-bar > span { display:block; height:100%; background:#2f85ae; }
@media print {
    .top-nav, .week-bar .week-nav, .week-bar form button, .actions, .no-print, footer { display:none !important; }
    .kpi-grid { grid-template-columns:repeat(4,1fr); page-break-inside:avoid; }
    table.weekly-projects { font-size:11px; }
    a { color:#000; text-decoration:none; }
}
@media (max-width: 720px) { .kpi-grid { grid-template-columns:repeat(2,1fr); } }
</style>
<?php $this->end(); ?>

<div class="reports weekly content">
    <div class="page-header">
        <h3><?php echo h($this->fetch('title')); ?></h3>
        <span style="color:#888; font-size:13px;">
            <?php echo h($weekStart); ?> &mdash; <?php echo h($weekEnd); ?>
       </span>
   </div>

    <div class="week-bar no-print">
        <div class="week-nav">
            <a href="<?php echo $this->Url->build(['controller' => 'Reports', 'action' => 'weekly', '?' => ['year' => (int)$prev->format('o'), 'week' => (int)$prev->format('W')]]); ?>">&laquo; Prev</a>
            <a href="<?php echo $this->Url->build(['controller' => 'Reports', 'action' => 'weekly', '?' => ['year' => (int)date('Y'), 'week' => (int)date('W')]]); ?>">This Week</a>
            <a href="<?php echo $this->Url->build(['controller' => 'Reports', 'action' => 'weekly', '?' => ['year' => (int)$next->format('o'), 'week' => (int)$next->format('W')]]); ?>">Next &raquo</a>
       </div>
        <?php echo $this->Form->create(null, ['type' => 'get', 'url' => ['controller' => 'Reports', 'action' => 'weekly']]); ?>
            <label>Year
                <input type="number" name="year" value="<?php echo h($year); ?>" min="1970" max="2100">
           </label>
            <label>Week
                <input type="number" name="week" value="<?php echo h($week); ?>" min="1" max="53">
           </label>
            <button type="submit" class="button">Go</button>
        <?php echo $this->Form->end(); ?>
        <?php echo $this->Html->link('Print', ['action' => 'weekly', '?' => array_merge((array)$this->request->getQuery(), ['print' => 1])], ['class' => 'button', 'target' => '_blank']); ?>
   </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-label">Active Projects</div>
            <div class="kpi-value"><?php echo (int)$kpis['active_projects']; ?></div>
            <div class="kpi-sub">Currently in progress</div>
       </div>
        <div class="kpi-card">
            <div class="kpi-label">Tasks Completed</div>
            <div class="kpi-value"><?php echo (int)$kpis['tasks_completed']; ?></div>
            <div class="kpi-sub">Reached 100% this week</div>
       </div>
        <div class="kpi-card">
            <div class="kpi-label">Tasks Added</div>
            <div class="kpi-value"><?php echo (int)$kpis['tasks_added']; ?></div>
            <div class="kpi-sub">New tasks created this week</div>
       </div>
        <div class="kpi-card">
            <div class="kpi-label">Hours Logged</div>
            <div class="kpi-value"><?php echo number_format((float)$kpis['hours_logged'], 1); ?></div>
            <div class="kpi-sub">Sum of spent hours, tasks updated this week</div>
       </div>
   </div>

    <h4 style="margin-top:8px;">Per-Project Breakdown</h4>
    <div class="table-responsive">
        <table class="weekly-projects">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Manager</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th style="text-align:right;">Completed</th>
                    <th style="text-align:right;">Hours</th>
                    <th>At Risk</th>
               </tr>
           </thead>
            <tbody>
                <?php if (empty($rows)): ?>
                    <tr><td colspan="7" style="text-align:center; color:#888; padding:24px;">No projects found</td</tr>
                <?php endif; ?>
                <?php foreach ($rows as $r):
                    $p = $r['project'];
                    $statusName = strtolower((string)($p->project_status->status_tx ?? ''));
                    $statusClass = 'status-badge';
                    if (str_contains($statusName, 'active') || str_contains($statusName, 'progress')) {
                        $statusClass .= ' status-active';
                    } elseif (str_contains($statusName, 'hold')) {
                        $statusClass .= ' status-onhold';
                    } elseif (str_contains($statusName, 'clos') || str_contains($statusName, 'complet')) {
                        $statusClass .= ' status-closed';
                    } elseif (str_contains($statusName, 'cancel')) {
                        $statusClass .= ' status-cancelled';
                    }
                    $progress = max(0, min(100, (int)($p->progress ?? 0)));
                ?>
                <tr>
                    <td>
                        <?php echo $this->Html->link(
                            h($p->name),
                            ['controller' => 'Reports', 'action' => 'projectWeekly', $p->id, '?' => ['year' => $year, 'week' => $week]]
                        ); ?>
                   </td>
                    <td><?php echo h($p->manager_obj->display_name_tx ?? '-'); ?></td>
                    <td><span class="<?php echo h($statusClass); ?>"><?php echo h($p->project_status->status_tx ?? '-');?></span</span</td>
                    <td>
                        <div class="progress-bar"><span style="width:<?php echo (int)$progress; ?> ?>%</span</div>
                        <small style="color:#888;"><?php echo (int)$progress; ?>%</small>
                   </td>
                    <td style="text-align:right;"><?php echo (int)$r['completed_this_week']; ?></td>
                    <td style="text-align:right;"><?php echo number_format((float)$r['hours_this_week'], 1); ?></td>
                    <td>
                        <?php if ($r['at_risk']): ?>
                            <span class="risk-dot" title="<?php echo (int)$r['at_risk_count']; ?> task(s) over budget</span>
                            <small style="color:#c62828;"><?php echo (int)$r['at_risk_count']; ?> over</small>
                        <?php else: ?>
                            <span class="risk-dot clean</span>
                        <?php endif; ?>
                   </td>
               </tr>
                <?php endforeach; ?>
           </tbody>
       </table>
   </div>
</div>
