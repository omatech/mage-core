<?php

namespace Omatech\Mage\Core\Repositories;

use Illuminate\Support\Facades\DB;
use Omatech\Lars\BaseRepository;
use Omatech\Mage\Core\Domains\Permissions\Contracts\PermissionInterface;
use Omatech\Mage\Core\Domains\Roles\Contracts\RoleInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\AllUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\CreateUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\DeleteUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\ExistsUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\FindUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UniqueUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UpdateUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Events\Users\UserCreated;
use Omatech\Mage\Core\Events\Users\UserDeleted;
use Omatech\Mage\Core\Events\Users\UserUpdated;
use Omatech\Mage\Core\Models\User;

class UserRepository extends BaseRepository implements AllUserInterface, CreateUserInterface, DeleteUserInterface, ExistsUserInterface, UpdateUserInterface, UniqueUserInterface, FindUserInterface
{
    /**
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->query()->paginate()->toArray();
    }

    /**
     * @param int $id
     * @return mixed|null
     */
    public function find(int $id)
    {
        $user = $this->query()->find($id);

        if (null === $user) {
            return null;
        }

        $permissions = array_map(static function ($permission) {
            return app()->make(PermissionInterface::class)::find($permission['id']);
        }, $user->permissions->toArray());

        $roles = array_map(static function ($role) {
            return app()->make(RoleInterface::class)::find($role['id']);
        }, $user->roles->toArray());

        $user = app()->make(UserInterface::class)::fromArray([
            'id'                => $user->id,
            'name'              => $user->name,
            'language'          => $user->language,
            'email'             => $user->email,
            'email_verified_at' => $user->verified_at,
            'password'          => $user->password,
            'remember_token'    => $user->remember_token,
            'created_at'        => $user->created_at,
            'updated_at'        => $user->updated_at,
        ]);

        $user->assignPermissions($permissions);
        $user->assignRoles($roles);

        return $user;
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function create(UserInterface $user): bool
    {
        $wasRecentlyCreated = DB::transaction(function () use ($user) {
            $created = $this->query()->create([
                'name'              => $user->getName(),
                'language'          => $user->getLanguage(),
                'email'             => $user->getEmail(),
                'email_verified_at' => $user->getEmailVerifiedAt(),
                'password'          => $user->getPassword(),
                'remember_token'    => $user->getRememberToken(),
            ]);

            $user->setId($created->id);
            $user->setCreatedAt($created->created_at);
            $user->setUpdatedAt($created->updated_at);

            $this->syncPermissions($created, $user);
            $this->syncRoles($created, $user);

            return $created->wasRecentlyCreated;
        });

        event(new UserCreated($user, $wasRecentlyCreated));

        return $wasRecentlyCreated;
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function exists(UserInterface $user): bool
    {
        return $this->query()
            ->where('email', $user->getEmail())
            ->orWhere('id', $user->getId())
            ->exists();
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function unique(UserInterface $user): bool
    {
        return $this->query()
            ->where('email', $user->getEmail())
            ->where('id', '!=', $user->getId())
            ->exists();
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function update(UserInterface $user): bool
    {
        $isUpdated = DB::transaction(function () use ($user) {
            $updated = $this->query()->find($user->getId());

            $updated->fill([
                'name'              => $user->getName(),
                'language'          => $user->getLanguage(),
                'email'             => $user->getEmail(),
                'email_verified_at' => $user->getEmailVerifiedAt(),
                'password'          => $user->getPassword(),
                'remember_token'    => $user->getRememberToken(),
            ])->save();

            $user->setCreatedAt($updated->created_at);
            $user->setUpdatedAt($updated->updated_at);

            $this->syncPermissions($updated, $user);
            $this->syncRoles($updated, $user);

            return count($updated->getChanges()) >= 1;
        });

        event(new UserUpdated($user, $isUpdated));

        return $isUpdated;
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function delete(UserInterface $user): bool
    {
        $isDeleted = $this->query()
            ->where('id', $user->getId())
            ->delete();

        $isDeleted = $isDeleted > 0;

        event(new UserDeleted($user, $isDeleted));

        return $isDeleted;
    }

    /**
     * @param User          $model
     * @param UserInterface $user
     */
    private function syncPermissions(User $model, UserInterface $user): void
    {
        $model->syncPermissions($user->getPermissionsIds());
    }

    /**
     * @param User          $model
     * @param UserInterface $user
     */
    private function syncRoles(User $model, UserInterface $user): void
    {
        $model->syncRoles($user->getRolesIds());
    }
}
