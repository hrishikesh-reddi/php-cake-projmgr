<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * Lightweight session auth for the Geminitools app.
 *
 * Replaces the (uninstalled) cakephp/authentication plugin with a
 * simple session-backed identity stored at `Auth.User`.
 */
class AuthComponent extends Component
{
    private const SESSION_KEY = 'Auth.User';

    /**
     * Current logged-in user payload (array) or null.
     */
    public function user(): ?array
    {
        $session = $this->getController()->getRequest()->getSession();
        $user = $session->read(self::SESSION_KEY);

        return is_array($user) ? $user : null;
    }

    public function isLoggedIn(): bool
    {
        return $this->user() !== null;
    }

    public function id(): ?int
    {
        $user = $this->user();

        return $user ? (int)$user['id'] : null;
    }

    /**
     * Persist the logged-in identity in the session.
     */
    public function login(array $user): void
    {
        $this->getController()->getRequest()->getSession()->write(self::SESSION_KEY, $user);
    }

    /**
     * Clear the identity + nuke the session.
     */
    public function logout(): void
    {
        $session = $this->getController()->getRequest()->getSession();
        $session->delete(self::SESSION_KEY);
        $session->destroy();
    }
}