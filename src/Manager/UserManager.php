<?php

namespace App\Manager;

use App\Contract\Manager\UserManagerInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

class UserManager implements UserManagerInterface
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(User::class);
        if (!$repo instanceof UserRepository) {
            throw new RuntimeException('The repo for User must be a UserRepository, but got '
                . get_class($repo));
        }
        $this->repository = $repo;
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function createOrUpdate(User $user, bool $flush = true): void
    {
        if ($user->getId() === null) {
            $this->entityManager->persist($user);
        }
        if ($flush === true) {
            $this->entityManager->flush();
        }
    }

    /**
     * @inheritDoc
     */
    public function remove(User $user, bool $flush = true): void
    {
        $this->entityManager->remove($user);
        if ($flush === true) {
            $this->entityManager->flush();
        }
    }
}