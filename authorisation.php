<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Метросервис</title>
</head>

<body>

    <form action="authorisation.php" method="POST">

        <label for="login">Логин: <input type="text" id="login" name="login"></label>
        <label for="password">Пароль: <input type="password" id="password" name="password"></label>
        <input type="submit" name="submit" id="submit" value="Войти">

    </form>
    <a href="register.php">Зарегестрироваться</a>


    <?php 

    function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
                $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }

    if (isset($_POST['submit'])){
    
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "MetroServis";

    

    $conn = new mysqli($servername, $username, $password, $dbname);
    $query = mysqli_query(mysql: $conn, query:'SELECT id, password FROM users WHERE login="'.$_POST['login'].'" LIMIT 1');
    $data = mysqli_fetch_assoc($query);
    echo($data['password'] .'<br>'. md5(md5($_POST['password'])));
    if($data['password'] === md5(md5($_POST['password'])))
    {
    $hash = md5(generateCode(10));

    mysqli_query($conn, "UPDATE users SET hash='".$hash."' WHERE id='".$data['id']."'");
    setcookie("id", $data['id'], time()+60*60*24*30, "/");
    setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true);
    header("Location: index.php"); exit();

    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
    }

    ?>
</body>

</html>