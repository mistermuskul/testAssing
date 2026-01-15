<?php

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers()
    {
        return $this->userRepository->getAll();
    }

    public function getUserById($id)
    {
        return $this->userRepository->getById($id);
    }

    public function createUser($name, $email = null)
    {
        return $this->userRepository->create($name, $email);
    }

    public function updateUser($id, $name, $email = null)
    {
        $user = $this->userRepository->getById($id);
        if (!$user) {
            return null;
        }
        return $this->userRepository->update($id, $name, $email);
    }

    public function deleteUser($id)
    {
        $user = $this->userRepository->getById($id);
        if (!$user) {
            return false;
        }
        return $this->userRepository->delete($id);
    }
}

