<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>МетроСервис</title>
    <link href="styles/styles.css" rel="stylesheet" />
</head>
<body>
    <header>
        <div class="info_part">

        </div>
        <nav>
            <a href="#" class="nav_item">Заказы</a>
            <?php
            $conn=mysqli_connect('localhost','root','mysql','MetroServis');
            $user_permission = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = \"".intval($_COOKIE['id'])."\" LIMIT 1")))['position'];
            if ($user_permission === 'Руководитель'){
                echo('
                <a href="aboutUs_options.php" class="nav_item">Настройки</a>
                <a href="users.php" class="nav_item">Пользователи</a>
                ');
            }
            ?>
            <a href="profile.php" class="nav_item">Профиль</a>
        </nav>
    </header>

    <br><br><a href="logout.php">Выход</a>
</body>
</html>