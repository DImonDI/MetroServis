<!DOCTYPE html>
<html lang="en">
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
    <table cellspacing="0">
    <?php 

    $conn = new mysqli('localhost', 'root','mysql','MetroServis');
    $sql = "SELECT * FROM Users";
    if($result = $conn->query($sql))
    echo("<tr>
            <td>Логин</td> 
            <td>Почта</td> 
            <td>Должность</td>
            <td>СНИЛС</td>
            <td>Контактное лицо (ФИО)</td>
            <td>Номер телефона</td>
            <td>Название компании</td>
            <td></td>
            </tr>");{
        foreach($result as $row){
            $login = $row["login"];
            $email = $row["email"];
            $position = $row["position"];
            $snils = ($position != 'Клиент') ? $row['SNILS'] : '—';
            $id = $row['id'];
            $client_info = mysqli_fetch_assoc(mysqli_query($conn,'SELECT * FROM client_info WHERE user_id="'.$id.'"'));
            $contact_person = isset($client_info) ? $client_info['contact_person'] : '—' ;
            $tel_num = isset($client_info) ? $client_info['tel_num'] : '—' ;
            $company_name = isset($client_info) ? $client_info['company_name'] : '—' ;
            echo("<tr>
            <td>$login</td> 
            <td>$email</td> 
            <td>$position</td>
            <td>$snils</td>
            <td>$contact_person</td>
            <td>$tel_num</td>
            <td>$company_name</td>
            <td><form action=\"admins_user_control_form.php\" method=\"POST\">
            <input name=\"selected_user\" id=\"selected_user\" type=\"hidden\" value=\"".$id."\">
            <input name=\"action_type\" id=\"action_type\" type=\"hidden\" value=\"Подтвердить\">
            <input type=\"submit\" value=\"Редактировать\">
            </form></td></tr>");
        }
    }
    ?>
    </table>
    <form action="admins_user_control_form.php" method="POST">
        <input type="submit" value="Создать нового пользователя">
        <input name="selected_user" id="selected_user" type="hidden" value="-1">
        <input name="action_type" id="action_type" type="hidden" value="Зарегестрировать">
    </form>
    <br>

</body>
</html>