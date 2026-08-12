<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, int|float>         $kpis
 * @var array<int, array<string, mixed>> $budgetAdherence
 * @var array<int, array<string, mixed>> $resourceUtilization
 * @var array<int, array<string, mixed>> $topFinishers
 * @var array<int, array<string, mixed>> $atRiskProjects
 */
$this->assign('title', 'Forecasting Dashboard');

$fmtInt = static fn (int|float $n): string => number_format((float)$n, 0);
$fmtHours = static fn (int|float $n): string => number_format((float)$n, 1);
$fmtMoney = static fn (int|float $n, string $cur): string =>
    ($cur === '' ? 'USD' : $cur) . ' ' . number_format((float)$n, 0);
?>
<style>
    .dashboard { font-family: 'Roboto', 'Helvetica Neue', Arial, sans-serif; color: #1f2937; }
    .dashboard h1 { margin: 0 0 0.25rem 0; font-size: 1.6rem; font-weight: 600; }
    .dashboard .subtitle { color: #6b7280; margin-bottom: 1.5rem; font-size: 0.95rem; }

    .kpi-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem; }
    @media (max-width: 900px) { .kpi-row { grid-template-columns: repeat(2, 1fr); } }
    .kpi-card {
        background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px;
        padding: 1.1rem 1.2rem; box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        display: flex; flex-direction: column; gap: 0.35rem;
    }
    .kpi-card .label { font-size: 0.78rem; text-transform: uppercase; color: #6b7280; letter-spacing: 0.04em; font-weight: 600; }
    .kpi-card .value { font-size: 1.85rem; font-weight: 700; color: #111827; line-height: 1.1; }
    .kpi-card .hint  { font-size: 0.78rem; color: #6b7280; }
    .kpi-card.accent-blue   { border-top: 3px solid #2563eb; }
    .kpi-card.accent-amber  { border-top: 3px solid #f59e0b; }
    .kpi-card.accent-green  { border-top: 3px solid #10b981; }
    .kpi-card.accent-red    { border-top: 3px solid #ef4444; }

    .panel { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 1.5rem; overflow: hidden; }
    .panel-header { padding: 0.85rem 1.2rem; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; }
    .panel-header h2 { margin: 0; font-size: 1.05rem; font-weight: 600; color: #111827; }
    .panel-header .meta { color: #6b7280; font-size: 0.85rem; }
    .panel-body { padding: 0.5rem 1.2rem 1rem; }
    .panel-body.tight { padding: 0; }

    table.forecast { width: 100%; border-collapse: collapse; font-size: 0.92rem; }
    table.forecast th, table.forecast td { padding: 0.6rem 0.75rem; text-align: left; border-bottom: 1px solid #f1f5f9; }
    table.forecast th { background: #f8fafc; color: #374151; font-weight: 600; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.03em; }
    table.forecast tr:last-child td { border-bottom: 0; }
    table.forecast td.num, table.forecast th.num { text-align: right; font-variant-numeric: tabular-nums; }

    .badge { display: inline-block; padding: 0.18rem 0.55rem; border-radius: 999px; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.03em; }
    .badge-green { background: #d1fae5; color: #065f46; }
    .badge-amber { background: #fef3c7; color: #92400e; }
    .badge-red   { background: #fee2e2; color: #991b1b; }
    .badge-blue  { background: #dbeafe; color: #1e40af; }
    .badge-gray  { background: #f3f4f6; color: #4b5563; }

    .ratio-bar { display: inline-block; height: 6px; width: 80px; background: #f3f4f6; border-radius: 3px; overflow: hidden; vertical-align: middle; margin-right: 0.4rem; }
    .ratio-bar > span { display: block; height: 100%; background: #10b981; }
    .ratio-bar > span.warn { background: #f59e0b; }
    .ratio-bar > span.over { background: #ef4444; }

    .empty-state { padding: 2rem 1rem; text-align: center; color: #9ca3af; font-style: italic; }

    .grid-two { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; }
    @media (max-width: 1100px) { .grid-two { grid-template-columns: 1fr; } }
</style>

<div class="dashboard">
    <h1>Forecasting Dashboard</h1>
    <p class="subtitle">Budget adherence, resource utilization, and project risk at a glance</p>

    <div class="kpi-row">
        <div class="kpi-card accent-blue">
            <div class="label">Active Projects</div>
            <div class="value"><?= $fmtInt($kpis['active_projects']) ?></div>
            <div class="hint">New, In Progress, On Hold</div>
      </div>
        <div class="kpi-card accent-red">
            <div class="label">Tasks Over Budget</div>
            <div class="value"><?= $fmtInt($kpis['tasks_over_budget']) ?></div>
            <div class="hint">Spent &ge; estimated</div>
      </div>
        <div class="kpi-card accent-green">
            <div class="label">Total Estimated Hours</div>
            <div class="value"><?= $fmtHours($kpis['total_estimated']) ?></div>
            <div class="hint">Across all tasks</div>
      </div>
        <div class="kpi-card accent-amber">
            <div class="label">Total Spent Hours</div>
            <div class="value"><?= $fmtHours($kpis['total_spent']) ?></div>
            <div class="hint">Logged effort to date</div>
      </div>
  </div>

    <div class="panel">
        <div class="panel-header">
            <h2>Budget Adherence</h2>
            <span class="meta">Per active project &mdash; effort ratio = spent &divide; estimated</span>
      </div>
        <div class="panel-body tight">
            <?php if ($budgetAdherence === []): ?>
                <div class="empty-state">No active projects to report</div>
            <?php else: ?>
                <table class="forecast">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Manager</th>
                            <th class="num">Budget</th>
                            <th class="num">Estimated (h</th>
                            <th class="num">Spent (h</th>
                            <th class="num">Effort Ratio</th>
                            <th>Status</th>
                      </tr>
                  </thead>
                    <tbody>
                        <?php foreach ($budgetAdherence as $row):
                            $ratio = (float)$row['ratio'];
                            $barClass = $ratio >= 1.2 ? 'over' : ($ratio >= 1.0 ? 'warn' : '');
                            $barWidth = min(100.0, $ratio * 50.0);
                        ?>
                        <tr>
                            <td><?= h($row['name']) ?></td>
                            <td><?= h($row['manager']) ?></td>
                            <td class="num"><?= h($fmtMoney($row['budget'], (string)$row['currency'])) ?></td>
                            <td class="num"><?= $fmtHours($row['estimated']) ?></td>
                            <td class="num"><?= $fmtHours($row['spent']) ?></td>
                            <td class="num">
                                <span class="ratio-bar"><span class="<?= h($barClass) ?>" style="width: <?= number_format($barWidth, 1) ?>%"></span></span>
                                <?= number_format($ratio, 2) ?>&times;
                          </td>
                            <td><span class="<?= h($row['badge']['class']) ?>"><?= h($row['badge']['label']) ?></span></td>
                      </tr>
                        <?php endforeach; ?>
                  </tbody>
              </table>
            <?php endif; ?>
      </div>
  </div>

    <div class="grid-two">
        <div class="panel">
            <div class="panel-header">
                <h2>Resource Utilization</h2>
                <span class="meta">Top 10 by hours spent</span>
          </div>
            <div class="panel-body tight">
                <?php if ($resourceUtilization === []): ?>
                    <div class="empty-state">No task assignments yet</div>
                <?php else: ?>
                    <table class="forecast">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th class="num">Tasks</th>
                                <th class="num">Estimated (h)</th>
                                <th class="num">Spent (h)</th>
                                <th class="num">Avg Completion</th>
                           </tr>
                       </thead>
                        <tbody>
                            <?php foreach ($resourceUtilization as $row):
                                $completion = (float)$row['avg_completion'];
                                $cBadge = $completion >= 80 ? 'badge-green' : ($completion >= 50 ? 'badge-amber' : 'badge-red');
                            ?>
                            <tr>
                                <td><?= h($row['display_name']) ?></td>
                                <td class="num"><?= $fmtInt($row['task_count']) ?></td>
                                <td class="num"><?= $fmtHours($row['total_estimated']) ?></td>
                                <td class="num"><?= $fmtHours($row['total_spent']) ?></td>
                                <td class="num"><span class="badge <?= $cBadge ?>"><?= number_format($completion, 1) ?>%</span></td>
                          </tr>
                            <?php endforeach; ?>
                      </tbody>
                  </table>
                <?php endif; ?>
          </div>
      </div>

        <div>
            <div class="panel">
                <div class="panel-header">
                    <h2>Top Finishers</h2>
                    <span class="meta">100% completed</span>
              </div>
                <div class="panel-body tight">
                    <?php if ($topFinishers === []): ?>
                        <div class="empty-state">No completed tasks yet</div>
                    <?php else: ?>
                        <table class="forecast">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th class="num">Done</th>
                              </tr>
                          </thead>
                            <tbody>
                                <?php foreach ($topFinishers as $row): ?>
                                <tr>
                                    <td><?= h($row['display_name']) ?></td>
                                    <td class="num"><span class="badge badge-green"><?= $fmtInt($row['finished_count']) ?></span></td>
                              </tr>
                                <?php endforeach; ?>
                          </tbody>
                      </table>
                    <?php endif; ?>
              </div>
          </div>

            <div class="panel">
                <div class="panel-header">
                    <h2>At-Risk Projects</h2>
                    <span class="meta">Cost approved &middot; < 30% progress &middot; ends &le; 30 days</span>
              </div>
                <div class="panel-body tight">
                    <?php if ($atRiskProjects === []): ?>
                        <div class="empty-state">Nothing at risk. Nice</div>
                    <?php else: ?>
                        <table class="forecast">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Manager</th>
                                    <th class="num">Days Left</th>
                              </tr>
                          </thead>
                            <tbody>
                                <?php foreach ($atRiskProjects as $row):
                                    $days = (int)$row['days_remaining'];
                                    $dBadge = $days <= 7 ? 'badge-red' : ($days <= 14 ? 'badge-amber' : 'badge-blue');
                                ?>
                                <tr>
                                    <td><?= h($row['name']) ?></td>
                                    <td><?= h($row['manager']) ?></td>
                                    <td class="num"><span class="badge <?= $dBadge ?>"><?= $days ?>d</span></td>
                              </tr>
                                <?php endforeach; ?>
                          </tbody>
                      </table>
                    <?php endif; ?>
              </div>
          </div>
      </div>
  </div>
</div>
