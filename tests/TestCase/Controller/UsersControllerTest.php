<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Datasource\FactoryLocator;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Functional tests for the auth module (UsersController).
 *
 * Runs against the geminitools_test database (schema loaded from
 * tests/schema.sql) with the seed user provided by UsersFixture.
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = ['app.Users'];

    public function setUp(): void
    {
        parent::setUp();
        // Integration requests hit the app's 'default' connection; point it at
        // the test database so fixture data is visible and no dev data is touched.
        ConnectionManager::alias('test', 'default');
    }

    public function tearDown(): void
    {
        ConnectionManager::dropAlias('default');
        parent::tearDown();
    }

    public function testLoginPageRendersUnauthenticated(): void
    {
        $this->get('/login');
        $this->assertResponseOk();
        $this->assertResponseContains('Sign in');
        $this->assertResponseContains('Email');
        $this->assertResponseContains('Password');
    }

    public function testUsersIndexRedirectsToLoginWhenUnauthenticated(): void
    {
        $this->get('/users');
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/login');
    }

    public function testLoginWithWrongPasswordRejectsAndTracksFailure(): void
    {
        $this->enableCsrfToken();

        $this->post('/login', [
            'email'    => 'rmaram@gemini-us.com',
            'password' => 'WrongPassword1',
        ]);

        $this->assertResponseCode(200);
        $this->assertResponseContains('Invalid email or password');
        $this->assertSessionNotHasKey('Auth.User');

        $user = FactoryLocator::get('Table')->get('Users')->get(3);
        $this->assertSame(1, (int)$user->login_failures_nm);
        $this->assertNotNull($user->last_login_failure_dt);
    }

    public function testLoginWithCorrectCredentialsSucceeds(): void
    {
        $this->enableCsrfToken();

        $this->post('/login', [
            'email'    => 'rmaram@gemini-us.com',
            'password' => 'Test@1234',
        ]);

        $this->assertResponseCode(302);
        $this->assertRedirectContains('/users');
        $this->assertFlashMessageContains('Welcome back');

        // Session identity established.
        $this->assertSession(3, 'Auth.User.id');
        $this->assertSession('rmaram@gemini-us.com', 'Auth.User.email_tx');

        // Login tracking: last_login stamped, failures reset.
        $user = FactoryLocator::get('Table')->get('Users')->get(3);
        $this->assertNotNull($user->last_login_dt);
        $this->assertSame(0, (int)$user->login_failures_nm);
        $this->assertNull($user->last_login_failure_dt);
    }

    public function testUsersIndexRendersWhenLoggedIn(): void
    {
        $this->session(['Auth' => ['User' => [
            'id'              => 3,
            'display_name_tx' => 'Raghavendra Maram',
            'email_tx'        => 'rmaram@gemini-us.com',
            'employee_id'     => 'GI1008',
        ]]]);

        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseContains('Raghavendra');
        $this->assertResponseContains('rmaram@gemini-us.com');
    }

    public function testRegisterCreatesActiveAccount(): void
    {
        $this->enableCsrfToken();

        $this->post('/register', [
            'display_name_tx'   => 'Jane Doe',
            'email_tx'          => 'jdoe@gemini-us.com',
            'mobile_tx'         => '9999999999',
            'password_tx'       => 'Secret@123',
            'confirm_password'  => 'Secret@123',
        ]);

        $this->assertResponseCode(302);
        $this->assertRedirectContains('/login');
        $this->assertFlashMessageContains('Account created');

        $user = FactoryLocator::get('Table')->get('Users')->findByEmail('jdoe@gemini-us.com');
        $this->assertNotNull($user);
        $this->assertSame(1, (int)$user->activate_yn_nm);
        // Stored password is hashed, never plaintext.
        $this->assertNotSame('Secret@123', $user->password_tx);
    }

    public function testRegisterRejectsMismatchedPasswordConfirmation(): void
    {
        $this->enableCsrfToken();

        $this->post('/register', [
            'display_name_tx'   => 'Jane Doe',
            'email_tx'          => 'jdoe@gemini-us.com',
            'password_tx'       => 'Secret@123',
            'confirm_password'  => 'Different!',
        ]);

        $this->assertResponseCode(200);
        $this->assertResponseContains('confirmation does not match');
    }
}