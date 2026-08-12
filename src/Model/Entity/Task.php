<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Task Entity — CakePHP 5.x (maps to task_t)
 */
class Task extends Entity
{
    protected array $_accessible = [
        'task_name_tx'        => true,
        'description_tx'      => true,
        'uniq_id'             => true,
        'project_id_nm'       => true,
        'billability_nm'      => true,
        'parent_task_nm'      => true,
        'milestone_id_nm'     => true,
        'created_by_nm'       => true,
        'priority_nm'         => true,
        'start_date_dt'       => true,
        'estimated_hours_nm'  => true,
        'revised_efforts_nm'  => true,
        'spent_hours_nm'      => true,
        'due_date_dt'         => true,
        'projected_date_dt'   => true,
        'completion'          => true,
        'task_type_nm'        => true,
        'task_status_nm'      => true,
        'comments'            => true,
        'created_at_dt'       => true,
        'updated_at_dt'       => true,
        'project'             => true,
        'task_status'         => true,
        'task_type'           => true,
        'created_by_user'     => true,
        'sub_tasks'           => true,
    ];

    protected array $_hidden = [];

    /**
     * Effort ratio = spent / (estimated ?: 1).
     * "ON TRACK" ratio < 1, "AT RISK" 1 <= ratio < 1.2, "OVER" ratio >= 1.2.
     */
    public function _getEffortRatio(): float
    {
        $estimated = (float)($this->estimated_hours_nm ?: 0);
        $denominator = $estimated > 0 ? $estimated : 1.0;

        return round((float)($this->spent_hours_nm ?? 0) / $denominator, 2);
    }

    public function _getEffortStatus(): string
    {
        $ratio = (float)$this->effort_ratio;

        if ($ratio < 1.0) {
            return 'ON TRACK';
        }
        if ($ratio < 1.2) {
            return 'AT RISK';
        }

        return 'OVER';
    }

    /**
     * True when the task is not resolved/closed and the due date has passed.
     */
    public function _getOverdue(): bool
    {
        if (in_array($this->task_status_nm, [4, 5], true)) {
            return false;
        }

        $due = $this->due_date_dt;
        if ($due === null || $due === '') {
            return false;
        }

        $formatter = null;
        if ($due instanceof \DateTimeInterface) {
            $formatter = fn ($d): string => \DateTimeImmutable::createFromInterface($d)->format('Y-m-d');
        } elseif (is_object($due) && method_exists($due, 'format')) {
            $formatter = fn ($d): string => (string)$d->format('Y-m-d');
        }

        if ($formatter === null) {
            $dueDate = \DateTimeImmutable::createFromFormat('Y-m-d', (string)$due);
            if ($dueDate === false) {
                return false;
            }

            return $dueDate->format('Y-m-d') < (new \DateTimeImmutable('now'))->format('Y-m-d');
        }

        return $formatter($due) < (new \DateTimeImmutable('now'))->format('Y-m-d');
    }

    /**
     * Short label + css class for the effort badge.
     */
    public function _getEffortBadge(): array
    {
        return match ((string)$this->effort_status) {
            'ON TRACK' => ['label' => 'ON TRACK', 'class' => 'badge badge-green'],
            'AT RISK'  => ['label' => 'AT RISK',  'class' => 'badge badge-amber'],
            'OVER'     => ['label' => 'OVER BUDGET', 'class' => 'badge badge-red'],
            default    => ['label' => 'ON TRACK', 'class' => 'badge badge-green'],
        };
    }
}
