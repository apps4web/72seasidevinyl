<?php
declare(strict_types=1);

namespace App\Policy;

use Authorization\IdentityInterface;
use Authorization\Policy\ResultInterface;
use Authorization\Policy\RequestPolicyInterface;
use Cake\Http\ServerRequest;

/**
 * Request policy for route-level authorization.
 */
class RequestPolicy implements RequestPolicyInterface
{
    /**
     * Authorize incoming requests.
     *
     * @param \Authorization\IdentityInterface|null $user Current identity.
     * @param \Cake\Http\ServerRequest $request Request instance.
     * @return bool
     */
    public function canAccess(?IdentityInterface $user, ServerRequest $request): bool|ResultInterface
    {
        $prefix = (string)($request->getParam('prefix') ?? '');
        $controller = strtolower((string)$request->getParam('controller'));
        $action = strtolower((string)$request->getParam('action'));

        // Public website pages remain public.
        if ($prefix !== 'Admin') {
            return true;
        }

        // Allow guests to reach the login page.
        if ($controller === 'users' && $action === 'login') {
            return true;
        }

        // Everything else in /admin requires an authenticated identity.
        return $user !== null;
    }
}
