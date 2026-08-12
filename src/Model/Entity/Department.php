<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Department Entity — maps to `department_t`.
 */
class Department extends Entity
{
    protected array $_accessible = [
        'name_tx'        => true,
        'is_active_yn'   => true,
        'created_at_dt'  => true,
        'updated_at_dt'  => true,
    ];
}