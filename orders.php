<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>МетроСервис</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>
<body>
    <header>
        <div class="info_part">

        </div>
        <nav>
            <a href="orders.php" class="nav_item">Заказы</a>
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
    <table class="orders" cellspacing="0">
        <?php
            echo("<tr>
                    <td>№Заказа</td>
                    <td>Дата</td>
                    <td>Статус</td>
                    <td></td>
                    </tr>");
            if ($result = $conn->query('SELECT * FROM orders')){
                foreach ($result as $row){
                    echo("<tr>
                    <td>".$row['id']."</td>
                    <td>".date('d-m-Y', strtotime($row['date']))."</td>
                    <td>".$row['status']."</td>
                    <td><form action=\"order_card.php\" method=\"POST\">
                    <input name=\"selected_order\" id=\"selected_order\" type=\"hidden\" value=\"".$row['id']."\">
                    <input type=\"submit\" value=\"Посмотреть\">
                    </form></td>
                    </tr>");
                }
            }
        ?>
    </table>
    
</body>
</html>