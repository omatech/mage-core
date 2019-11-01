<?php

namespace Omatech\Mage\Core\Domains\Permissions;

use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Permissions\Exceptions\PermissionIsNotSavedException;

class PermissionModel
{
    /**
     * @param array               $currentPermissions
     * @param PermissionInterface $assignPermission
     *
     * @throws PermissionIsNotSavedException
     *
     * @return array
     */
    public function assignPermission(array $currentPermissions, PermissionInterface $assignPermission): array
    {
        if (null === $assignPermission->getId()) {
            throw new PermissionIsNotSavedException();
        }

        if (! in_array($assignPermission, $currentPermissions, true)) {
            $currentPermissions[] = $assignPermission;
        }

        return $currentPermissions;
    }

    /**
     * @param array $currentPermissions
     * @param array $assignPermissions
     *
     * @throws PermissionIsNotSavedException
     *
     * @return array
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
     * @param array               $currentPermissions
     * @param PermissionInterface $deletePermission
     *
     * @throws PermissionIsNotSavedException
     *
     * @return array
     */
    public function removePermission(array $currentPermissions, PermissionInterface $deletePermission): array
    {
        if (null === $deletePermission->getId()) {
            throw new PermissionIsNotSavedException();
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
     *
     * @throws PermissionIsNotSavedException
     *
     * @return array
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
