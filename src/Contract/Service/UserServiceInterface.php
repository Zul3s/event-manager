<?php

namespace App\Contract\Service;

use App\Entity\User;

interface UserServiceInterface
{
    /**
     * @param User $user
     * @return void
     */
    public function createOrUpdate(User $user): void;
}