<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;

function buildSchema(UserResolvers $resolvers)
{
    $userType = new ObjectType([
        'name' => 'User',
        'fields' => [
            'id' => Type::int(),
            'name' => Type::string(),
            'email' => Type::string(),
            'created_at' => Type::string(),
        ],
    ]);

    $queryType = new ObjectType([
        'name' => 'Query',
        'fields' => [
            'users' => [
                'type' => Type::listOf($userType),
                'resolve' => function ($rootValue, array $args, $context, $info) use ($resolvers) {
                    return $resolvers->resolveUsers($rootValue, $args, $context, $info);
                },
            ],
            'getUser' => [
                'type' => $userType,
                'args' => [
                    'id' => Type::nonNull(Type::int()),
                ],
                'resolve' => function ($rootValue, array $args, $context, $info) use ($resolvers) {
                    return $resolvers->resolveGetUser($rootValue, $args, $context, $info);
                },
            ],
        ],
    ]);

    $mutationType = new ObjectType([
        'name' => 'Mutation',
        'fields' => [
            'createUser' => [
                'type' => $userType,
                'args' => [
                    'name' => Type::nonNull(Type::string()),
                ],
                'resolve' => function ($rootValue, array $args, $context, $info) use ($resolvers) {
                    return $resolvers->resolveCreateUser($rootValue, $args, $context, $info);
                },
            ],
        ],
    ]);

    return new Schema([
        'query' => $queryType,
        'mutation' => $mutationType,
    ]);
}

