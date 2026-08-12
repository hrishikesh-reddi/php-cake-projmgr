<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Timesheet Entity — CakePHP 5.x (maps to `timesheets`)
 */
class Timesheet extends Entity
{
    protected array $_accessible = [
        'year'                          => true,
        'week_number'                   => true,
        'user_id'                       => true,
        'project_id'                    => true,
        'task_id'                       => true,
        'is_billable'                   => true,
        'is_default_task'               => true,
        'default_project_id'            => true,
        'default_task_id'               => true,
        'approved_hours'                => true,
        'user_comments'                 => true,
        'reporting_manager_id'          => true,
        'reporting_manager_action'      => true,
        'reporting_manager_comment'     => true,
        'project_manager_id'            => true,
        'project_manager_action'        => true,
        'project_manager_approved_hrs'  => true,
        'project_manager_comment'       => true,
        'submitted_date'                => true,
        'rm_approved_date'              => true,
        'timesheet_status'              => true,
        'timesheet_comment'             => true,
        'created'                       => true,
        'modified'                      => true,
        'user'                          => true,
        'project'                       => true,
        'task'                          => true,
        'reporting_manager'             => true,
        'project_manager'               => true,
    ];

    protected array $_hidden = [];
}
