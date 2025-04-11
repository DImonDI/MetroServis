<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>МетроСервис</title>
    <link href="styles/styles.css" rel="stylesheet" />
</head>
<body>
    <p><b>Профиль</b></p>
    <?php
    
    $link=mysqli_connect("localhost", "root", "mysql", "MetroServis");

        if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
        {
            $query = mysqli_query($link, "SELECT *,INET_NTOA(ip) AS ip FROM users WHERE id = \"".intval($_COOKIE['id'])."\" LIMIT 1");
            $userdata = mysqli_fetch_assoc($query);

            if(($userdata['hash'] !== $_COOKIE['hash']) or ($userdata['id'] !== $_COOKIE['id']))
            {
                setcookie("id", "", time() - 3600*24*30*12, "/");
                setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
                print "Хм, что-то не получилось";
            }
            else
            {
                echo("<br>Логин: ".$userdata['login']."<br>Снилс: ".$userdata['SNILS'] . "<br>Почта: ".$userdata['email'] . "<br>Должность:".$userdata['position']);
            }
        }
        else
        {
            header("Location: authorisation.php"); exit();;
        }
    
    ?>
    <br><br><a href="logout.php">Выход</a>
</body>
</html>