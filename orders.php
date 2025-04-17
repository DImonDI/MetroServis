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
            $link=mysqli_connect('localhost','root','mysql','MetroServis');
            $user_permission = (mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id = \"".intval($_COOKIE['id'])."\" LIMIT 1")))['position'];
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
    <table>
    <?php 

    // $link = new mysqli('localhost', 'root','mysql','MetroServis');
    // $sql = "SELECT * FROM orders";
    // if($result = $link->query($sql)){
    //     foreach($result as $row){
             
    //         $login = $row["login"];
    //         $email = $row["email"];
    //         $position = $row["position"];
    //         echo("<tr><td>$login</td> <td>$email</td> <td>$position</td><td><button>Редактировать</button></td></tr>");
    //     }
    // }
    ?>
    </table>
    
</body>
</html>