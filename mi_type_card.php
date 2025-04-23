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
    <table class="order_mi_card" cellspacing="0">
    <?php 

    $conn = new mysqli('localhost', 'root','mysql','MetroServis');
    $sql = 'SELECT * FROM orders_mi WHERE order_id="'.$_POST['selected_order'].'" AND type="'.$_POST['selected_type'].'" LIMIT 25';
    if($result = $conn->query($sql)){
        if (mysqli_num_rows($result)>0){
            echo("<tr>
            <td>№Госреестр</td>
            <td>Наименование</td>
            <td>Тип</td>
            <td>Модификация</td>
            <td>Эталоны</td>
            <td>Год вып.</td>
            <td>Зав.№</td>
            <td>Ср-ва пов.</td>
            <td>Cостав СИ</td>
            <td>Дата поверки</td>
            <td>Пов. дейст. до</td>
            <td>№ФИФ</td>
            <td>Владелец</td>
            <td>Поверитель</td>
            <td>Стажер</td>
            <td>Вид пов.</td>
            <td>Знак поверки на СИ</td>
            <td>Знак поверки в паспорте</td>
            <td>Пригодность</td>
            </tr>");
            foreach($result as $row){

                $gos_num = $row['gos_num'];
                $name = $row['name'];
                $type = $row['type'];
                $modification = $row['modification'];
                $stand_mi = $row['stand_mi'];
                $cr_date = $row['cr_date'];
                $zav_num = $row['zav_num'];
                $used_mi = $row['used_mi_id'];
                $mi_comp = $row['mi_comp'];
                $ver_date = $row['ver_date'];
                $ver_end_date = $row['ver_end_date'];            
                $fif_num = $row['fif_num'];
                $owner_id = $row['owner_id'];
                $trustee_id = $row['trustee_id'];
                $intern_id = $row['intern_id'];
                $ver_type = $row['ver_type'];
                $ver_mark_MI = $row['ver_mark_MI'];
                $ver_mark_pas = $row['ver_mark_pas'];
                $suitable = $row['suitable'];

                echo("<tr>
                <td>".$gos_num."</td>
                <td>".$name."</td>
                <td>".$type."</td>
                <td>".$modification."</td>
                <td>".$stand_mi."</td>
                <td>".$cr_date."</td>
                <td>".$zav_num."</td>
                <td>".$used_mi."</td>
                <td>".$mi_comp."</td>
                <td>".$ver_date."</td>
                <td>".$ver_end_date."</td>
                <td>".$fif_num."</td>
                <td>".$owner_id."</td>
                <td>".$trustee_id."</td>
                <td>".$intern_id."</td>
                <td>".$ver_type."</td>
                <td>".$ver_mark_MI."</td>
                <td>".$ver_mark_pas."</td>
                <td>".$suitable."</td>
                </tr>"); 
            }
        } else {
            header('Location: orders.php'); exit();
        }
    }
    ?>
    </table>
    
</body>
</html>