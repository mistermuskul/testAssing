<?php

use GraphQL\Type\Definition\ResolveInfo;

class UserResolvers
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function resolveUsers($rootValue, array $args, $context, ResolveInfo $info)
    {
        return $this->userService->getUsers();
    }

    public function resolveGetUser($rootValue, array $args, $context, ResolveInfo $info)
    {
        return $this->userService->getUserById($args['id']);
    }

    public function resolveCreateUser($rootValue, array $args, $context, ResolveInfo $info)
    {
        return $this->userService->createUser($args['name']);
    }
}

