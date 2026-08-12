<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Milestone Entity — CakePHP 5.x (maps to project_milestones_t)
 */
class Milestone extends Entity
{
    protected array $_accessible = [
        'milestone_type'            => true,
        'title_tx'                  => true,
        'parent_milestone_id'       => true,
        'description_tx'            => true,
        'uniq_id'                   => true,
        'project_id_nm'             => true,
        'currency'                  => true,
        'billable_type'             => true,
        'billable_amount_nm'        => true,
        'percent_complete_nm'       => true,
        'start_date_dt'             => true,
        'end_date_dt'               => true,
        'actual_start_date_dt'      => true,
        'actual_end_date_dt'        => true,
        'duration'                  => true,
        'assigned_to'               => true,
        'class_name'                => true,
        'dependent'                 => true,
        'comments'                  => true,
        'caption'                   => true,
        'status'                    => true,
        'delivery_milestone_status' => true,
        'financial_milestone_status'=> true,
        'created_at_dt'             => true,
        'updated_at_dt'             => true,
        'project'                   => true,
        'tasks'                     => true,
    ];

    protected array $_hidden = [];
}