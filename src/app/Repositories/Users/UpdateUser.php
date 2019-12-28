<?php

namespace Omatech\Mage\Core\Repositories\Users;

use Omatech\Mage\Core\Domains\Users\Contracts\UpdateUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Events\Users\UserUpdated;
use Omatech\Mage\Core\Repositories\UserBaseRepository;

class UpdateUser extends UserBaseRepository implements UpdateUserInterface
{
    /**
     * @param UserInterface $user
     * @return bool
     */
    public function update(UserInterface $user): bool
    {
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

        event(new UserUpdated($user, count($updated->getChanges()) >= 1));

        return count($updated->getChanges()) >= 1;
    }
}
