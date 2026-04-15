<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Record;
use Authorization\IdentityInterface;
use Cake\Datasource\EntityInterface;

/**
 * Record entity authorization policy.
 */
class RecordPolicy
{
    /**
     * Anyone can view records.
     *
     * @param \Authorization\IdentityInterface|null $user Current identity.
     * @param \App\Model\Entity\Record $record Record entity.
     * @return bool
     */
    public function canView(?IdentityInterface $user, Record $record): bool
    {
        return true;
    }

    /**
     * Only admins can add records.
     *
     * @param \Authorization\IdentityInterface|null $user Current identity.
     * @param \App\Model\Entity\Record $record Record entity.
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Record $record): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Only admins can edit records.
     *
     * @param \Authorization\IdentityInterface|null $user Current identity.
     * @param \App\Model\Entity\Record $record Record entity.
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Record $record): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Only admins can delete records.
     *
     * @param \Authorization\IdentityInterface|null $user Current identity.
     * @param \App\Model\Entity\Record $record Record entity.
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Record $record): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Check whether the identity represents an authenticated admin user.
     *
     * @param \Authorization\IdentityInterface|null $user Current identity.
     * @return bool
     */
    private function isAdmin(?IdentityInterface $user): bool
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