<?php

namespace Omatech\Mage\Core\Domains\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleIsNotSavedException;

class RoleModel
{
    /**
     * @param array $currentRoles
     * @param RoleInterface $assignRole
     * @return array
     * @throws RoleIsNotSavedException
     */
    public function assignRole(array $currentRoles, RoleInterface $assignRole): array
    {
        if ($assignRole->getId() === null) {
            throw new RoleIsNotSavedException;
        }

        if (! in_array($assignRole, $currentRoles, true)) {
            $currentRoles[] = $assignRole;
        }

        return $currentRoles;
    }

    /**
     * @param array $currentRoles
     * @param array $assignRoles
     * @return array
     * @throws RoleIsNotSavedException
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
     * @param array $currentRoles
     * @param RoleInterface $deleteRole
     * @return array
     * @throws RoleIsNotSavedException
     */
    public function removeRole(array $currentRoles, RoleInterface $deleteRole): array
    {
        if ($deleteRole->getId() === null) {
            throw new RoleIsNotSavedException;
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
     * @return array
     * @throws RoleIsNotSavedException
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
