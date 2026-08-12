<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Project Entity — CakePHP 5.x
 * All properties typed as required by CakePHP 5.
 */
class Project extends Entity
{
    // CakePHP 5 requires typed property declarations
    protected array $_accessible = [
        'name'                => true,
        'short_name'          => true,
        'project_code'        => true,
        'description'         => true,
        'uniq_id'             => true,
        'company_id'          => true,
        'status_id'           => true,
        'type_id'             => true,
        'technology_id'       => true,
        'project_manager'     => true,
        'account_manager'     => true,
        'project_coordinator' => true,
        'initiator'           => true,
        'start_date'          => true,
        'end_date'            => true,
        'budget'              => true,
        'cost_approved'       => true,
        'priority'            => true,
        'billable_type'       => true,
        'billability'         => true,
        'scope'               => true,
        'sector'              => true,
        'currency'            => true,
        'rate'                => true,
        'estimated_hours'     => true,
        'progress'            => true,
        'isactive'            => true,
        'dt_created'          => true,
        'dt_updated'          => true,
        // Association objects (using propertyName aliases)
        'project_status'      => true,
        'type_obj'            => true,
        'manager_obj'         => true,
        'account_mgr_obj'     => true,
        'tasks'               => true,
        'project_resources'   => true,
    ];

    protected array $_hidden = [];

    /**
     * Effort ratio = SUM(task_t.spent_hours_nm) / project.estimated_hours.
     * Returns null when no budget (estimated_hours) is set.
     * "ON TRACK" ratio < 1, "AT RISK" 1 <= ratio < 1.2, "OVER" ratio >= 1.2.
     */
    public function _getEffortRatio(): ?float
    {
        $estimated = (float)($this->estimated_hours ?: 0);
        if ($estimated <= 0) {
            return null;
        }

        $tasksTable = $this->getTableLocator()->get('Tasks');
        $query = $tasksTable->find();
        $row = $query
            ->where(['Tasks.project_id_nm' => $this->id])
            ->select(['spent' => $query->func()->sum('spent_hours_nm')])
            ->first();

        $spent = (float)($row->spent ?? 0);

        return round($spent / $estimated, 2);
    }

    public function _getEffortStatus(): string
    {
        $ratio = $this->effort_ratio;
        if ($ratio === null) {
            return 'NO BUDGET';
        }

        if ($ratio < 1.0) {
            return 'ON TRACK';
        }
        if ($ratio < 1.2) {
            return 'AT RISK';
        }

        return 'OVER';
    }

    /**
     * Short label + css class for the project's effort badge.
     */
    public function _getEffortBadge(): array
    {
        return match ((string)$this->effort_status) {
            'ON TRACK'  => ['label' => 'ON TRACK',    'class' => 'badge badge-green'],
            'AT RISK'   => ['label' => 'AT RISK',     'class' => 'badge badge-amber'],
            'OVER'      => ['label' => 'OVER BUDGET', 'class' => 'badge badge-red'],
            'NO BUDGET' => ['label' => 'NO BUDGET',   'class' => 'badge badge-grey'],
            default     => ['label' => 'ON TRACK',    'class' => 'badge badge-green'],
        };
    }
}
