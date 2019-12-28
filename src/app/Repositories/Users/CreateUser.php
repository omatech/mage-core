<?php

namespace Omatech\Mage\Core\Repositories\Users;

use Omatech\Mage\Core\Domains\Users\Contracts\CreateUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Events\Users\UserCreated;
use Omatech\Mage\Core\Repositories\UserBaseRepository;

class CreateUser extends UserBaseRepository implements CreateUserInterface
{
    /**
     * @param UserInterface $user
     * @return bool
     */
    public function create(UserInterface $user): bool
    {
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

        event(new UserCreated($user, $created->wasRecentlyCreated));

        return $created->wasRecentlyCreated;
    }
}
