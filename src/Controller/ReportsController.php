<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use DateTimeImmutable;

/**
 * Reports Controller
 *
 * Org-wide + per-project weekly status reports.
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 * @property \App\Model\Table\TasksTable $Tasks
 */
class ReportsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->Projects = TableRegistry::getTableLocator()->get('Projects');
        $this->Tasks = TableRegistry::getTableLocator()->get('Tasks');
    }

    /**
     * Resolve ?year and ?week to ISO-week Monday-Sunday bounds.
     *
     * @return array{0:int,1:int,2:string,3:string,4:string,5:string} year, week, startDate, endDate, startDt, endDt
     */
    private function resolveWeek(): array
    {
        $year = (int)($this->request->getQuery('year') ?? date('Y'));
        $week = (int)($this->request->getQuery('week') ?? date('W'));

        if ($year < 1970 || $year > 2100) {
            $year = (int)date('Y');
        }
        if ($week < 1 || $week > 53) {
            $week = (int)date('W');
        }

        $start = (new DateTimeImmutable())->setISODate($year, $week);
        $end = $start->modify('+6 days');

        return [
            $year,
            $week,
            $start->format('Y-m-d'),
            $end->format('Y-m-d'),
            $start->format('Y-m-d') . ' 00:00:00',
            $end->format('Y-m-d') . ' 23:59:59',
        ];
    }

    /**
     * GET /reports/weekly[?year=YYYY&week=N[&print=1]]
     *
     * Org-wide weekly report: 4 KPI cards + per-project breakdown.
     */
    public function weekly(): void
    {
        [$year, $week, $weekStart, $weekEnd, $startDt, $endDt] = $this->resolveWeek();

        // ----- KPIs -----
        $activeProjects = $this->Projects->find()
            ->where(['Projects.isactive' => 1])
            ->count();

        $tasksCompleted = $this->Tasks->find()
            ->where(['Tasks.completion' => 100])
            ->where(['Tasks.updated_at_dt >=' => $startDt, 'Tasks.updated_at_dt <=' => $endDt])
            ->count();

        $tasksAdded = $this->Tasks->find()
            ->where(['Tasks.created_at_dt >=' => $startDt, 'Tasks.created_at_dt <=' => $endDt])
            ->count();

        $hoursLoggedRow = $this->Tasks->find()
            ->select([
                'total' => $this->Tasks->find()->func()->sum('Tasks.spent_hours_nm'),
            ])
            ->where(['Tasks.updated_at_dt >=' => $startDt, 'Tasks.updated_at_dt <=' => $endDt])
            ->first();

        $hoursLogged = (float)($hoursLoggedRow->total ?? 0);

        // ----- Per-project breakdown -----
        $projects = $this->Projects->find()
            ->contain([
                'ProjectStatuses',
                'ProjectManagers',
            ])
            ->orderAsc('Projects.name')
            ->all();

        $rows = [];
        foreach ($projects as $project) {
            $pid = (int)$project->id;

            $completed = $this->Tasks->find()
                ->where(['Tasks.project_id_nm' => $pid, 'Tasks.completion' => 100])
                ->where(['Tasks.updated_at_dt >=' => $startDt, 'Tasks.updated_at_dt <=' => $endDt])
                ->count();

            $hoursRow = $this->Tasks->find()
                ->select([
                    'total' => $this->Tasks->find()->func()->sum('Tasks.spent_hours_nm'),
                ])
                ->where(['Tasks.project_id_nm' => $pid])
                ->where(['Tasks.updated_at_dt >=' => $startDt, 'Tasks.updated_at_dt <=' => $endDt])
                ->first();

            // At-risk = any task whose spent hours exceeds estimated hours.
            $atRisk = $this->Tasks->find()
                ->where([
                    'Tasks.project_id_nm' => $pid,
                    'Tasks.spent_hours_nm > Tasks.estimated_hours_nm',
                ])
                ->count();

            $rows[] = [
                'project' => $project,
                'completed_this_week' => $completed,
                'hours_this_week' => (float)($hoursRow->total ?? 0),
                'at_risk' => $atRisk > 0,
                'at_risk_count' => $atRisk,
            ];
        }

        $kpis = [
            'active_projects' => $activeProjects,
            'tasks_completed' => $tasksCompleted,
            'tasks_added' => $tasksAdded,
            'hours_logged' => $hoursLogged,
        ];

        $this->set(compact('year', 'week', 'weekStart', 'weekEnd', 'kpis', 'rows'));

        if ($this->request->getQuery('print')) {
            $this->viewBuilder()->setTemplate('print');
        }
    }

    /**
     * GET /reports/project/{id}/weekly[?year=YYYY&week=N[&print=1]]
     */
    public function projectWeekly(int $id): void
    {
        [$year, $week, $weekStart, $weekEnd, $startDt, $endDt] = $this->resolveWeek();

        $project = $this->Projects->get($id, [
            'contain' => [
                'ProjectStatuses',
                'ProjectManagers',
            ],
        ]);

        // Tasks updated this week.
        $tasksThisWeek = $this->Tasks->find()
            ->contain(['TaskStatuses', 'CreatedByUser'])
            ->where(['Tasks.project_id_nm' => $id])
            ->where(['Tasks.updated_at_dt >=' => $startDt, 'Tasks.updated_at_dt <=' => $endDt])
            ->orderDesc('Tasks.updated_at_dt')
            ->all();

        // Effort summary across ALL project tasks (not just this week).
        $allTasks = $this->Tasks->find()
            ->where(['Tasks.project_id_nm' => $id])
            ->all();

        $onTrack = 0;
        $atRisk = 0;
        $over = 0;
        foreach ($allTasks as $t) {
            $status = (string)$t->effort_status;
            if ($status === 'OVER') {
                $over++;
            } elseif ($status === 'AT RISK') {
                $atRisk++;
            } else {
                $onTrack++;
            }
        }

        // Team contribution — group ALL project tasks by created_by.
        $contributions = [];
        foreach ($allTasks as $t) {
            $uid = (int)($t->created_by_nm ?? 0);
            if ($uid === 0) {
                continue;
            }
            if (!isset($contributions[$uid])) {
                $contributions[$uid] = [
                    'name' => $t->created_by_user->display_name_tx ?? ('User #' . $uid),
                    'count' => 0,
                    'hours' => 0.0,
                ];
            }
            $contributions[$uid]['count']++;
            $contributions[$uid]['hours'] += (float)($t->spent_hours_nm ?? 0);
        }
        usort($contributions, static fn ($a, $b) => $b['hours'] <=> $a['hours']);

        $this->set(compact(
            'project',
            'year',
            'week',
            'weekStart',
            'weekEnd',
            'tasksThisWeek',
            'onTrack',
            'atRisk',
            'over',
            'contributions'
        ));

        if ($this->request->getQuery('print')) {
            $this->viewBuilder()->setTemplate('print');
        }
    }
}
