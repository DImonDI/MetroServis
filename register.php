<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>МетроСервис</title>
</head>
<body>
    <?
    $conn=mysqli_connect("localhost", "root", "mysql",  "MetroServis");

    if(isset($_POST['submit']))
    {
        $err = [];
        if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
        {
            $err[] = "Логин может состоять только из букв английского алфавита и цифр";
        }

        if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 50)
        {
            $err[] = "Логин должен быть не меньше 5-и символов и не больше 50";
        }
        $query = mysqli_query($conn, "SELECT id FROM users WHERE login='".mysqli_real_escape_string($conn, $_POST['login'])."'");
        if(mysqli_num_rows($query) > 0)
        {
            $err[] = "Пользователь с таким логином уже существует в базе данных";
        }
        if(count($err) == 0)
        {

            $login = $_POST['login'];
            $password = md5(md5(trim($_POST['password'])));
            echo('INSERT INTO users SET login="'.$login.'", password="'. $password .'", postion="Клиент", email="' . $_POST['e-mail'] . '"');

            mysqli_query($conn,query: 'INSERT INTO users SET login="'.$login.'", password="'. $password .'", position="Клиент", email="' . $_POST['e-mail'] . '"');
            mysqli_query($conn,'INSERT INTO client_info SET user_id=(SELECT MAX(id) FROM users), contact_person="'.$_POST['contact_person'].'", tel_num="'.$_POST['tel_num'].'", company_name="'.$_POST['company_name'].'"');
            header("Location: authorisation.php"); exit();
        }
        else
        {
            foreach($err AS $error)
            {
                print $error."<br>";
            }
        }
    }
    ?>


        <form method="POST">
        <label for="login">Логин: 
            <input name="login" id="login" type="text" required>
        </label>
        <label for="password">Пароль: 
            <input name="password" id="password" type="text" required>
        </label>
        <label for="contact_person">Контактное лицо (ФИО): 
            <input name="contact_person" id="contact_person" type="text" required></label>
        <label for="tel_num">Телефон: 
            <input name="tel_num" id="tel_num" type="tel" required>
        </label>
        <label for="e-mail">Почта: 
            <input name="e-mail" id="e-mail" type="text" required>
        </label>
        <label for="company_name">Название компании: 
            <input name="company_name" id="company_name" type="text" required>
        </label>
        <input name="submit" type="submit" value="Зарегистрироваться">
        </form>
    <a href="authorisation.php">Войти в существующий аккаунт</a>
</body>
</html>