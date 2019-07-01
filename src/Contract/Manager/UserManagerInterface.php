<?php

namespace App\Contract\Manager;

use App\Entity\User;

interface UserManagerInterface
{
    /**
     * @param User $user
     * @param bool $flush
     * @return void
     */
    public function createOrUpdate(User $user, bool $flush = true): void;

    /**
     * @param User $user
     * @param bool $flush
     * @return void
     */
    public function remove(User $user, bool $flush = true): void;
}