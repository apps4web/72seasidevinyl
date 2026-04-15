<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\RecordsTable;
use Authorization\IdentityInterface;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query\SelectQuery;

/**
 * Records table authorization policy.
 */
class RecordsTablePolicy
{
    /**
     * Only admins can access record listings.
     *
     * @param \Authorization\IdentityInterface|null $user Current identity.
     * @param \App\Model\Table\RecordsTable $records Records table.
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, RecordsTable $records): bool
    {
        if ($user === null) {
            return false;
        }

        $originalUser = $user->getOriginalData();
        if ($originalUser instanceof EntityInterface) {
            return (string)$originalUser->get('role') === 'admin';
        }

        if (is_array($originalUser)) {
            return ($originalUser['role'] ?? null) === 'admin';
        }

        return false;
    }

    /**
     * Scope records index query.
     *
     * @param \Authorization\IdentityInterface|null $user Current identity.
     * @param \Cake\ORM\Query\SelectQuery $query Records query.
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function scopeIndex(?IdentityInterface $user, SelectQuery $query): SelectQuery
    {
        if ($this->canAccessIndex($user)) {
            return $query;
        }

        // Return an always-empty query for unauthorized identities.
        return $query->where('1 = 0');
    }

    /**
     * Internal helper for index access checks.
     *
     * @param \Authorization\IdentityInterface|null $user Current identity.
     * @return bool
     */
    private function canAccessIndex(?IdentityInterface $user): bool
    {
        if ($user === null) {
            return false;
        }

        $originalUser = $user->getOriginalData();
        if ($originalUser instanceof EntityInterface) {
            return (string)$originalUser->get('role') === 'admin';
        }

        if (is_array($originalUser)) {
            return ($originalUser['role'] ?? null) === 'admin';
        }

        return false;
    }
}