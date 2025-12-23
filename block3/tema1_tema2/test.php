<?php

require_once 'Database.php';
require_once 'Config.php';
require_once 'Validator.php';

echo "=== ТЕМА 1: Работа с PDO ===\n\n";

echo "Задание 1: Установка соединения с БД\n";
$db = new Database();
echo $db->connect() . "\n\n";

echo "Задание 2: Выполнение SELECT-запроса\n";
print_r($db->getUsers());
echo "\n";

echo "Задание 3: Добавление данных (INSERT)\n";
$db->addUser("Иван", "ivan@example.com");
print_r($db->getUsers());
echo "\n";

echo "Задание 4: Защита от SQL-инъекций (Prepared Statements)\n";
$db->addUser("Алексей', 'hacked@example.com'); DROP TABLE users; --", "hacker@example.com");
print_r($db->getUsers());
echo "\n";

echo "Задание 5: Удаление данных (DELETE)\n";
$db->deleteUser(1);
print_r($db->getUsers());
echo "\n\n";

echo "=== ТЕМА 2: Защита от SQL-инъекций ===\n\n";

echo "Задание 1: Использование подготовленных запросов (prepare, execute)\n";
$user = $db->getUserByEmail("ivan@example.com");
print_r($user);
echo "\n";
$result = $db->getUserByEmail("hacker@example.com' OR 1=1 --");
if ($result === false || isset($result['error'])) {
    echo "SQL-инъекция заблокирована - защита работает\n";
} else {
    echo "ОШИБКА: SQL-инъекция сработала!\n";
}
echo "\n";

echo "Задание 2: Безопасное добавление данных (INSERT)\n";
$db->addUser("Алексей', 'hacked@example.com'); DROP TABLE users; --", "hacker2@example.com", "123456");
print_r($db->getUsers());
echo "\n";

echo "Задание 3: Безопасное удаление данных (DELETE)\n";
$db->deleteUser("1 OR 1=1");
print_r($db->getUsers());
echo "\n";

echo "Задание 4: Экранирование данных (bindParam, bindValue)\n";
$db->addUser("Oleg", "oleg@example.com", "password");
print_r($db->getUserByEmail("oleg@example.com"));
echo "\n";

echo "Задание 5: Ограничение ввода данных (валидация)\n";
$result = $db->getUserByEmail("неправильный_адрес");
print_r($result);
echo "\n";

