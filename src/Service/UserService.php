<?php

namespace App\Service;

use App\Contract\Manager\UserManagerInterface;
use App\Contract\Service\UserServiceInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService implements UserServiceInterface
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserManagerInterface $userManager, UserPasswordEncoderInterface $encoder)
    {
        $this->userManager = $userManager;
        $this->encoder = $encoder;
    }

    /**
     * @inheritDoc
     */
    public function createOrUpdate(User $user): void
    {
        $this->encoder->isPasswordValid($user, $user->getPassword());
        $encodedPassword = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);
        $this->userManager->createOrUpdate($user);
    }
}