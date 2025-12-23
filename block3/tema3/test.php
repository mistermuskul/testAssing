<?php

require_once 'vendor/autoload.php';
require_once 'Config.php';
require_once 'Database/Manager.php';
require_once 'Database/SchemaManager.php';
require_once 'Eloquent/Database.php';
require_once 'Eloquent/User.php';
require_once 'Eloquent/Post.php';
require_once 'Doctrine/Database.php';

use App\Entity\User as DoctrineUser;
use App\Entity\Post as DoctrinePost;
use App\Repository\UserRepository;

function bcrypt($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

echo "=== ТЕМА 3: Работа с ORM ===\n\n";

echo "=== ELOQUENT ===\n\n";

$eloquentDb = new EloquentDatabase();
$eloquentDb->init();

$config = Config::getDbConfig();
$pdo = new PDO(
    "mysql:host={$config['host']};dbname={$config['dbname']}",
    $config['user'],
    $config['password']
);
$pdo->exec("DELETE FROM posts");
$pdo->exec("DELETE FROM users");

echo "Задание 1: Создание модели (Eloquent)\n";
$user = new User();
$user->name = "Иван";
$user->email = "ivan@example.com";
$user->password = bcrypt("secret");
$user->save();
echo "Данные сохранены в базе\n";
print_r($user->toArray());
echo "\n";

echo "Задание 2: Работа с отношениями (Eloquent)\n";
$post = new Post();
$post->title = "Первый пост";
$post->content = "Содержание поста";
$post->user_id = $user->id;
$post->save();
$post = Post::find($post->id);
echo $post->user->name . "\n";
echo "\n";

echo "=== DOCTRINE ===\n\n";

$doctrineDb = new DoctrineDatabase();
$entityManager = $doctrineDb->init();

echo "Задание 3: Doctrine – создание сущности\n";
$doctrineUser = new DoctrineUser();
$doctrineUser->setName("Анна");
$doctrineUser->setEmail("anna@example.com");
$entityManager->persist($doctrineUser);
$entityManager->flush();
echo "Пользователь добавлен в БД\n";
echo "ID: " . $doctrineUser->getId() . ", Name: " . $doctrineUser->getName() . "\n\n";

echo "Задание 4: Использование репозитория (Doctrine)\n";
$userRepository = $entityManager->getRepository(DoctrineUser::class);
$foundUser = $userRepository->findByEmail("ivan@example.com");
if ($foundUser) {
    echo "ID: " . $foundUser->getId() . ", Name: " . $foundUser->getName() . ", Email: " . $foundUser->getEmail() . "\n";
} else {
    echo "Пользователь не найден\n";
}
echo "\n";

echo "Задание 5: Отношения между сущностями (Doctrine)\n";
$doctrinePost = new DoctrinePost();
$doctrinePost->setTitle("Doctrine Post");
$doctrinePost->setContent("Content");
$doctrinePost->setUser($doctrineUser);
$entityManager->persist($doctrinePost);
$entityManager->flush();
$postRepo = $entityManager->getRepository(DoctrinePost::class);
$foundPost = $postRepo->find($doctrinePost->getId());
if ($foundPost) {
    echo $foundPost->getUser()->getName() . "\n";
}
echo "\n";

