<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Employee Entity — CakePHP 5.x (maps to users_t)
 */
class Employee extends Entity
{
    protected array $_accessible = [
        'employee_id'          => true,
        'display_name_tx'      => true,
        'email_tx'             => true,
        'mobile_tx'            => true,
        'password_tx'          => true,
        'joined_on'            => true,
        'primary_skill'        => true,
        'department_id'        => true,
        'sub_department_id'    => true,
        'division_id'          => true,
        'designation'          => true,
        'location_id'          => true,
        'reporting_manager_nm' => true,
        'is_competency_mgr'    => true,
        'is_reporting_manager' => true,
        'competency'           => true,
        'created_by_nm'        => true,
        'updated_by_nm'        => true,
        'activate_yn_nm'       => true,
        'created_at_dt'        => true,
        'updated_at_dt'        => true,
    ];

    protected array $_hidden = ['password_tx'];
}
