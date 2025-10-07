<?php

namespace toubilib\core\application\usecases;

use Exception;
use toubilib\core\application\ports\api\AuthNServiceInterface;
use toubilib\core\application\ports\api\UserProfileDTO;
use toubilib\core\application\ports\spi\repositoryInterfaces\UserRepositoryInterface;

class AuthnService implements AuthNServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function byCredentials(string $email, string $password): UserProfileDTO
    {
        $user = $this->userRepository->findByEmail($email);
        
        if ($user === null) {
            throw new Exception("Invalid credentials");
        }
        
        if (!$user->verifyPassword($password)) {
            throw new Exception("Invalid credentials");
        }
        
        return new UserProfileDTO(
            $user->getId(),
            $user->getEmail(),
            $user->getRole()
        );
    }
}