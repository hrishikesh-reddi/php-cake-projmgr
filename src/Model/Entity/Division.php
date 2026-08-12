<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Division Entity — maps to `division_t`.
 */
class Division extends Entity
{
    protected array $_accessible = [
        'name_tx'       => true,
        'is_active_yn'  => true,
        'created_at_dt' => true,
        'updated_at_dt' => true,
    ];
}