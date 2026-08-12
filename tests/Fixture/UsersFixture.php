<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture — seed row for the auth controller tests.
 *
 * Mirrors the real seed user: id=3, rmaram@gemini-us.com, bcrypt hash
 * matching the plaintext password Test@1234.
 */
class UsersFixture extends TestFixture
{
    public string $table = 'users_t';

    public array $records = [
        [
            'id'                 => 3,
            'employee_id'        => 'GI1008',
            'display_name_tx'    => 'Raghavendra Maram',
            'email_tx'           => 'rmaram@gemini-us.com',
            'mobile_tx'          => '123456789',
            'password_tx'        => '$2y$12$S0B1IWOIYyIyJcj6MyinaO/dT8F270aQvz/Bcx/nNTIJml.XBTu1.',
            'joined_on'          => null,
            'reporting_manager_nm' => 0,
            'created_by_nm'      => 1,
            'updated_by_nm'      => 1,
            'activate_yn_nm'     => 1,
            'last_login_dt'      => null,
            'login_failures_nm'  => 0,
            'last_login_failure_dt' => null,
            'created_at_dt'      => '2024-01-01 00:00:00',
            'updated_at_dt'      => '2024-01-01 00:00:00',
        ],
    ];
}