<?php

namespace Omatech\Mage\Core\Domains\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleIsNotSavedException;

class RoleModel
{
    /**
     * @param array         $currentRoles
     * @param RoleInterface $assignRole
     *
     * @throws RoleIsNotSavedException
     *
     * @return array
     */
    public function assignRole(array $currentRoles, RoleInterface $assignRole): array
    {
        if (null === $assignRole->getId()) {
            throw new RoleIsNotSavedException();
        }

        if (! in_array($assignRole, $currentRoles, true)) {
            $currentRoles[] = $assignRole;
        }

        return $currentRoles;
    }

    /**
     * @param array $currentRoles
     * @param array $assignRoles
     *
     * @throws RoleIsNotSavedException
     *
     * @return array
     */
    public function assignRoles(array $currentRoles, array $assignRoles): array
    {
        foreach ($assignRoles as $role) {
            if ($role instanceof RoleInterface) {
                $currentRoles = $this->assignRole($currentRoles, $role);
            }
        }

        return $currentRoles;
    }

    /**
     * @param array         $currentRoles
     * @param RoleInterface $deleteRole
     *
     * @throws RoleIsNotSavedException
     *
     * @return array
     */
    public function removeRole(array $currentRoles, RoleInterface $deleteRole): array
    {
        if (null === $deleteRole->getId()) {
            throw new RoleIsNotSavedException();
        }

        $currentRoles = array_values(array_filter(
            $currentRoles,
            static function ($currentRole) use ($deleteRole) {
                return $currentRole !== $deleteRole;
            }
        ));

        return $currentRoles;
    }

    /**
     * @param array $currentRoles
     * @param array $deleteRoles
     *
     * @throws RoleIsNotSavedException
     *
     * @return array
     */
    public function removeRoles(array $currentRoles, array $deleteRoles): array
    {
        foreach ($deleteRoles as $role) {
            if ($role instanceof RoleInterface) {
                $currentRoles = $this->removeRole($currentRoles, $role);
            }
        }

        return $currentRoles;
    }
}
