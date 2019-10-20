<?php

namespace Omatech\Mage\Core\Domains\Roles;

use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Roles\Exceptions\RoleIsNotSavedException;

class RoleModel
{
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

    public function assignRoles(array $currentRoles, array $assignRoles): array
    {
        foreach ($assignRoles as $role) {
            if ($role instanceof RoleInterface) {
                $currentRoles = $this->assignRole($currentRoles, $role);
            }
        }

        return $currentRoles;
    }

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
