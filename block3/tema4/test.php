<?php

require_once 'vendor/autoload.php';
require_once 'Config.php';
require_once 'Database/Connection.php';
require_once 'Database/MigrationManager.php';
require_once 'Database/SeederManager.php';
require_once 'Database/seeders/UserSeeder.php';
require_once 'Database/seeders/DatabaseSeeder.php';
require_once 'Database/factories/UserFactory.php';

use Illuminate\Database\Capsule\Manager as Capsule;

echo "=== ТЕМА 4: Миграции и сидирование ===\n\n";

$config = Config::getDbConfig();
$pdo = new PDO(
    "mysql:host={$config['host']};dbname={$config['dbname']}",
    $config['user'],
    $config['password']
);
$pdo->exec("DROP TABLE IF EXISTS migrations");
$pdo->exec("DROP TABLE IF EXISTS users");

DatabaseConnection::init();
$manager = new MigrationManager();

echo "Задание 1: Создание миграции для таблицы пользователей\n";
echo "Выполняем миграцию...\n";
echo $manager->migrate() . "\n";
$usersExist = Capsule::schema()->hasTable('users');
echo ($usersExist ? "Таблица users создана\n" : "ОШИБКА: Таблица users не создана\n");
echo "\n";

echo "Задание 2: Откат миграции (rollback)\n";
echo "Выполняем rollback...\n";
echo $manager->rollback() . "\n";
$usersExist = Capsule::schema()->hasTable('users');
if (!$usersExist) {
    echo "Таблица users удалена (rollback выполнен)\n";
} else {
    echo "Таблица users существует (rollback удалил только последнюю миграцию)\n";
}
echo "\n";

echo "Задание 3: Создание миграции с изменением структуры\n";
echo "Выполняем миграции...\n";
$result = $manager->migrate();
echo $result . "\n";
if (Capsule::schema()->hasTable('users')) {
    $hasRole = Capsule::schema()->hasColumn('users', 'role');
    echo ($hasRole ? "В таблице users появилось поле role\n" : "ОШИБКА: Поле role не добавлено\n");
} else {
    echo "ОШИБКА: Таблица users не существует\n";
}
echo "\n";

echo "Задание 4: Создание сидера для заполнения таблицы пользователями\n";
$seeder = new UserSeeder();
$seeder->run();
$userCount = Capsule::table('users')->count();
echo "В таблице users: {$userCount} пользователей\n";
if ($userCount >= 5) {
    echo "Сидер выполнен успешно\n";
    print_r(Capsule::table('users')->get()->toArray());
} else {
    echo "ОШИБКА: Недостаточно пользователей\n";
}
echo "\n";

echo "Задание 5: Заполнение БД фабриками (Eloquent Factory)\n";
Capsule::table('users')->truncate();
$factory = new DatabaseSeeder();
$factory->run();
$userCount = Capsule::table('users')->count();
echo "В таблице users: {$userCount} пользователей\n";
if ($userCount >= 10) {
    echo "Фабрика выполнилась успешно\n";
} else {
    echo "ОШИБКА: Недостаточно пользователей\n";
}
echo "\n";

echo "Задание 6: Миграции и сидирование в Doctrine\n";
require_once 'Database/Manager.php';
require_once 'Doctrine/Database.php';
require_once 'Doctrine/Entity/User.php';
require_once 'Doctrine/Fixtures/UserFixtures.php';

$doctrineDb = new DoctrineDatabase();
$entityManager = $doctrineDb->init();

$schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
$classes = [
    $entityManager->getClassMetadata(\App\Entity\User::class),
];

try {
    $schemaTool->createSchema($classes);
    echo "Doctrine миграция выполнена - таблица users создана\n";
} catch (\Exception $e) {
    echo "Doctrine миграция: " . $e->getMessage() . "\n";
}

$fixtures = new \App\Fixtures\UserFixtures();
$fixtures->load($entityManager);
$doctrineUserCount = $entityManager->getRepository(\App\Entity\User::class)->count([]);
echo "Doctrine фикстуры загружены - пользователей: {$doctrineUserCount}\n";
echo "\n";
