<?php

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserByEmail($email)
    {
        return $this->userRepository->findUserByEmail($email);
    }
}
