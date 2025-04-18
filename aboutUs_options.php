<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>МетроСервис</title>
    <link href="styles/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
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
    <?php
    $conn=mysqli_connect('localhost','root','mysql','MetroServis');
    $user_permission = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = \"".intval($_COOKIE['id'])."\" LIMIT 1")))['position'];
    if ($user_permission != 'Руководитель'){
        header('Location: profile.php'); exit();
    }
    ?>

    <div class="space">
        <div class="content">
            <form id="thatForm" class="reg_auth_form" action="aboutUs_update.php" method="POST">
                <label for="fname">Полное название организации: 
                    <input id="fname" name="fname" type="text">
                </label>
                <label for="sname">Соркащенное название организации: 
                    <input id="sname" name="sname" type="text">
                </label>
                <label for="adress">Адресса:
                    <input name="action" id="action" type="hidden" value="Save">
                    <div class="adress_container">
                        <button id="add">+</button> 
                        <div class="adress_string">
                            <input id="adress<?php echo(mysqli_fetch_assoc(mysqli_query($conn, 'SELECT MIN(id) FROM adres LIMIT 1')));?>" name="adress" type="text"><?php
                    
                    foreach($conn->query('SELECT * FROM adres WHERE id > (SELECT MIN(id) FROM adres LIMIT 1)') as $row){
                        echo('<div><input id="adress'.$row['id'].'" name="adress" type="text" value="'.$row['adres'].'"><button id="del">-</button></div>');
                    }
                    
                    ?></div></div>
                </label>
                <label for="accreditation_certificate">Аттестат акредитации:
                    <input id="accr_cert" name="accreditation_certificate" type="text">
                </label>
                <label for="verification_cipher_stamp">Шифр поверительного клейма:
                    <input id="ver_ciph_st" name="verification_cipher_stamp" type="text" placeholder="XXX" maxlength="3">
                </label>
                <input type="submit" value="Сохранить">
            </form>
        </div>
    </div>
    <script>
    $('#ver_ciph_st').on('keypress', function() {
        var that = this;

        setTimeout(function() {
            var res = /[^А-Я ]/g.exec(that.value);
            console.log(res);
            that.value = that.value.replace(res, '');
        }, 0);
    });
    function submitFuncbtns(){
        document.getElementById('thatForm').submit();
    }
    function addAdress(){
        const action = document.getElementById('action');
        action.value = 'add';
        submitFuncbtns();
    }
    function delAdress(){
        const action = document.getElementById('action');
        action.value = 'del';
        submitFuncbtns();
    }
    </script>

</body>
</html>