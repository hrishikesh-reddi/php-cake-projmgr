<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Database\Expression\QueryExpression;

/**
 * Dashboard Controller
 *
 * Forecasting + budget-adherence + resource-utilization dashboard.
 * This is the home page (`/`); see config/routes.php.
 *
 * - 4 KPI cards: active projects, tasks over budget, total estimated hours, total spent hours.
 * - Per-project budget adherence with effort-ratio badge.
 * - Resource utilization: top 10 users by hours spent.
 * - Employee performance: top 5 "finishers" (completion=100).
 * - At-risk projects: cost approved + low progress + near deadline.
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 * @property \App\Model\Table\TasksTable    $Tasks
 */
class DashboardController extends AppController
{
    /**
     * Active project statuses in `project_status_t` (geminitools DB).
     * 1=New, 2=InProgress, 4=Hold. Completed/Archived/Delivery are excluded.
     */
    private const ACTIVE_PROJECT_STATUSES = [1, 2, 4];

    public function initialize(): void
    {
        parent::initialize();
        $this->Projects = $this->fetchTable('Projects');
        $this->Tasks = $this->fetchTable('Tasks');
    }

    /**
     * Build all KPI blocks and forward to the view.
     */
    public function index(): void
    {
        $kpis = $this->buildKpis();
        $budgetAdherence = $this->buildBudgetAdherence();
        $resourceUtilization = $this->buildResourceUtilization();
        $topFinishers = $this->buildTopFinishers();
        $atRiskProjects = $this->buildAtRiskProjects();

        $this->set(compact(
            'kpis',
            'budgetAdherence',
            'resourceUtilization',
            'topFinishers',
            'atRiskProjects',
        ));
    }

    /**
     * Top-row KPI cards.
     *
     * @return array<string, int|float>
     */
    private function buildKpis(): array
    {
        $activeProjects = (int)$this->Projects->find()
            ->where(['Projects.status_id IN' => self::ACTIVE_PROJECT_STATUSES])
            ->count();

        $tasksOverBudget = (int)$this->Tasks->find()
            ->where(function (QueryExpression $exp): QueryExpression {
                return $exp->add('Tasks.spent_hours_nm >= Tasks.estimated_hours_nm');
            })
            ->where(['Tasks.estimated_hours_nm >' => 0])
            ->count();

        $hoursQuery = $this->Tasks->find();
        $hoursRow = $hoursQuery
            ->select([
                'estimated_hours' => $hoursQuery->func()->sum('Tasks.estimated_hours_nm'),
                'spent_hours'     => $hoursQuery->func()->sum('Tasks.spent_hours_nm'),
            ])
            ->first();

        return [
            'active_projects'    => $activeProjects,
            'tasks_over_budget'  => $tasksOverBudget,
            'total_estimated'    => (float)($hoursRow->estimated_hours ?? 0),
            'total_spent'        => (float)($hoursRow->spent_hours ?? 0),
        ];
    }

    /**
     * Budget adherence per active project.
     *
     * For each active project, sums estimated + spent hours across its tasks
     * and derives an effort ratio (spent / estimated). The ratio feeds the
     * same green/amber/red badge logic as Task::effort_badge.
     *
     * @return array<int, array<string, mixed>>
     */
    private function buildBudgetAdherence(): array
    {
        $projects = $this->Projects->find()
            ->contain(['ProjectStatuses', 'ProjectManagers'])
            ->where(['Projects.status_id IN' => self::ACTIVE_PROJECT_STATUSES])
            ->orderAsc('Projects.name')
            ->all();

        $projectIds = $projects->extract('id')->toList();
        $aggregates = $this->aggregateTasksByProject($projectIds);

        $rows = [];
        foreach ($projects as $project) {
            $estimated = (float)($aggregates[(int)$project->id]['estimated'] ?? 0);
            $spent = (float)($aggregates[(int)$project->id]['spent'] ?? 0);

            $ratio = $estimated > 0 ? round($spent / $estimated, 2) : 0.0;
            $badge = $this->effortBadge($ratio);

            $rows[] = [
                'id'           => (int)$project->id,
                'name'         => (string)$project->name,
                'budget'       => (float)($project->budget ?? 0),
                'currency'     => (string)($project->currency ?? 'USD'),
                'estimated'    => $estimated,
                'spent'        => $spent,
                'ratio'        => $ratio,
                'badge'        => $badge,
                'manager'      => $project->manager_obj->display_name_tx ?? '—',
            ];
        }

        return $rows;
    }

    /**
     * Resource utilization — top 10 by total spent hours.
     *
     * Groups `task_t` by `created_by_nm`, joins `CreatedByUser` for the
     * display name, and reports task count + hour totals + avg completion.
     *
     * @return array<int, array<string, mixed>>
     */
    private function buildResourceUtilization(): array
    {
        $query = $this->Tasks->find();
        $fn = $query->func();
        $query
            ->contain(['CreatedByUser'])
            ->select([
                'Tasks.created_by_nm',
                'task_count'      => $fn->count('Tasks.id'),
                'total_estimated' => $fn->sum('Tasks.estimated_hours_nm'),
                'total_spent'     => $fn->sum('Tasks.spent_hours_nm'),
                'avg_completion'  => $fn->avg('Tasks.completion'),
            ])
            ->where(['Tasks.created_by_nm IS NOT' => null])
            ->groupBy(['Tasks.created_by_nm'])
            ->orderBy(['total_spent' => 'DESC'])
            ->limit(10);

        $out = [];
        foreach ($query->all() as $row) {
            $out[] = [
                'user_id'         => (int)$row->created_by_nm,
                'display_name'    => $row->created_by_user->display_name_tx ?? 'Unknown',
                'task_count'      => (int)$row->task_count,
                'total_estimated' => (float)($row->total_estimated ?? 0),
                'total_spent'     => (float)($row->total_spent ?? 0),
                'avg_completion'  => round((float)($row->avg_completion ?? 0), 1),
            ];
        }

        return $out;
    }

    /**
     * Employee performance — top 5 users by count of 100%-completed tasks.
     *
     * @return array<int, array<string, mixed>>
     */
    private function buildTopFinishers(): array
    {
        $query = $this->Tasks->find();
        $fn = $query->func();
        $query
            ->contain(['CreatedByUser'])
            ->select([
                'Tasks.created_by_nm',
                'finished_count' => $fn->count('Tasks.id'),
            ])
            ->where(['Tasks.completion' => 100])
            ->groupBy(['Tasks.created_by_nm'])
            ->orderBy(['finished_count' => 'DESC'])
            ->limit(5);

        $out = [];
        foreach ($query->all() as $row) {
            $out[] = [
                'user_id'        => (int)$row->created_by_nm,
                'display_name'   => $row->created_by_user->display_name_tx ?? 'Unknown',
                'finished_count' => (int)$row->finished_count,
            ];
        }

        return $out;
    }

    /**
     * At-risk projects — approved budget but low progress and deadline near.
     *
     * @return array<int, array<string, mixed>>
     */
    private function buildAtRiskProjects(): array
    {
        $today = (new \DateTimeImmutable('today'))->format('Y-m-d');
        $horizon = (new \DateTimeImmutable('today'))->modify('+30 days')->format('Y-m-d');

        $projects = $this->Projects->find()
            ->contain(['ProjectManagers'])
            ->where([
                'Projects.cost_approved >' => 0,
                'Projects.progress <' => 30,
                'Projects.end_date IS NOT' => null,
                'Projects.end_date >=' => $today,
                'Projects.end_date <=' => $horizon,
            ])
            ->orderAsc('Projects.end_date')
            ->all();

        $todayDt = new \DateTimeImmutable('today');
        $out = [];
        foreach ($projects as $project) {
            $end = $project->end_date instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($project->end_date)
                : new \DateTimeImmutable((string)$project->end_date);
            $daysRemaining = (int)$todayDt->diff($end)->format('%r%a');

            $out[] = [
                'id'             => (int)$project->id,
                'name'           => (string)$project->name,
                'manager'        => $project->manager_obj->display_name_tx ?? '—',
                'progress'       => (int)($project->progress ?? 0),
                'cost_approved'  => (float)($project->cost_approved ?? 0),
                'end_date'       => $end->format('Y-m-d'),
                'days_remaining' => $daysRemaining,
            ];
        }

        return $out;
    }

    /**
     * Sum estimated + spent hours per project_id_nm.
     *
     * @param int[] $projectIds
     * @return array<int, array{estimated: float, spent: float}>
     */
    private function aggregateTasksByProject(array $projectIds): array
    {
        if ($projectIds === []) {
            return [];
        }

        $query = $this->Tasks->find();
        $sum = $query->func();
        $query
            ->select([
                'project_id_nm',
                'total_estimated' => $sum->sum('Tasks.estimated_hours_nm'),
                'total_spent'     => $sum->sum('Tasks.spent_hours_nm'),
            ])
            ->where(['Tasks.project_id_nm IN' => $projectIds])
            ->groupBy(['Tasks.project_id_nm']);

        $out = [];
        foreach ($query->all() as $row) {
            $out[(int)$row->project_id_nm] = [
                'estimated' => (float)($row->total_estimated ?? 0),
                'spent'     => (float)($row->total_spent ?? 0),
            ];
        }

        return $out;
    }

    /**
     * Same green/amber/red classification as Task::_getEffortBadge().
     *
     * @return array{label: string, class: string}
     */
    private function effortBadge(float $ratio): array
    {
        if ($ratio < 1.0) {
            return ['label' => 'ON TRACK', 'class' => 'badge badge-green'];
        }
        if ($ratio < 1.2) {
            return ['label' => 'AT RISK', 'class' => 'badge badge-amber'];
        }

        return ['label' => 'OVER BUDGET', 'class' => 'badge badge-red'];
    }
}
