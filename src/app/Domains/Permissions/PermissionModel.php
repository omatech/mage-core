<?php

namespace Omatech\Mage\Core\Domains\Permissions;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionIsNotSavedException;

class PermissionModel
{
    /**
     * @param array $currentPermissions
     * @param PermissionInterface $assignPermission
     * @return array
     * @throws PermissionIsNotSavedException
     */
    public function assignPermission(array $currentPermissions, PermissionInterface $assignPermission): array
    {
        if ($assignPermission->getId() === null) {
            throw new PermissionIsNotSavedException;
        }

        if (! in_array($assignPermission, $currentPermissions, true)) {
            $currentPermissions[] = $assignPermission;
        }

        return $currentPermissions;
    }

    /**
     * @param array $currentPermissions
     * @param array $assignPermissions
     * @return array
     * @throws PermissionIsNotSavedException
     */
    public function assignPermissions(array $currentPermissions, array $assignPermissions): array
    {
        foreach ($assignPermissions as $permission) {
            if ($permission instanceof PermissionInterface) {
                $currentPermissions = $this->assignPermission($currentPermissions, $permission);
            }
        }

        return $currentPermissions;
    }

    /**
     * @param array $currentPermissions
     * @param PermissionInterface $deletePermission
     * @return array
     * @throws PermissionIsNotSavedException
     */
    public function removePermission(array $currentPermissions, PermissionInterface $deletePermission): array
    {
        if ($deletePermission->getId() === null) {
            throw new PermissionIsNotSavedException;
        }

        $currentPermissions = array_values(array_filter(
            $currentPermissions,
            static function ($currentPermission) use ($deletePermission) {
                return $currentPermission !== $deletePermission;
            }
        ));

        return $currentPermissions;
    }

    /**
     * @param array $currentPermissions
     * @param array $deletePermissions
     * @return array
     * @throws PermissionIsNotSavedException
     */
    public function removePermissions(array $currentPermissions, array $deletePermissions): array
    {
        foreach ($deletePermissions as $permission) {
            if ($permission instanceof PermissionInterface) {
                $currentPermissions = $this->removePermission($currentPermissions, $permission);
            }
        }

        return $currentPermissions;
    }
}
