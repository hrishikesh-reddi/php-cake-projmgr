<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Role Entity — maps to `roles_t`.
 */
class Role extends Entity
{
    protected array $_accessible = [
        'name_tx'        => true,
        'short_name_tx'  => true,
        'user_role_nm'   => true,
        'is_active_nm'   => true,
        'created_at_dt'  => true,
        'updated_at_dt'  => true,
    ];
}