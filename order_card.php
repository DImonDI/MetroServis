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
    <table class="mi_list" cellspacing="0">
        <?php
            $conn = mysqli_connect('localhost', 'root', 'mysql', 'Metroservis');
            $id = $_POST['selected_order'];
            echo('<tr><td>Тип</td><td>№Госреестра</td><td>Заводские номера</td></tr>');
            foreach($conn->query("SELECT type, gos_num FROM orders_mi WHERE order_id=$id GROUP BY type, gos_num") as $row){
                $type = $row['type'];
                $gos_num = $row['gos_num'];
                $zav_num = [];
                foreach($conn->query("SELECT zav_num FROM orders_mi WHERE gos_num=$gos_num AND order_id=$id") as $el){
                    $zav_num [] =  (string)$el['zav_num'];
                }
                $zav_num= join(', ',$zav_num);
                echo("<tr><td>$type</td><td>$gos_num</td><td>$zav_num</td>
                <td><form action=\"mi_type_card.php\" method=\"POST\">
                <input name=\"selected_order\" id=\"selected_order\" type=\"hidden\" value=\"".$id."\">
                <input name=\"selected_type\" id=\"selected_type\" type=\"hidden\" value=\"".$row['type']."\">
                <input type=\"submit\" value=\"Посмотреть\">
                </form></td></tr>");
            }
            
        ?>
    </table>
    
</body>
</html>