<!DOCTYPE html>
<html>
<head>
    <title>Список пользователей</title>
</head>
<body>
    <h1>Список пользователей</h1>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?php echo htmlspecialchars($user['name']); ?> - <?php echo htmlspecialchars($user['email']); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

