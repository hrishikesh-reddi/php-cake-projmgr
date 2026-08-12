<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity — maps to users_t (auth module).
 *
 * Password hash is hidden from serialization. Login-tracking columns
 * and the employee_id (role-adjacent) field are deliberately NOT mass
 * assignable so a plain user can never change their own role or emp id.
 */
class User extends Entity
{
    protected array $_accessible = [
        'display_name_tx' => true,
        'email_tx'        => true,
        'mobile_tx'       => true,
        'password_tx'     => true,
        'joined_on'       => true,
    ];

    protected array $_hidden = ['password_tx'];
}