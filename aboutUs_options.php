<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>МетроСервис</title>
    <link href="styles/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <script>
        function addAdress() {
            const action = document.getElementById('action');
            action.value = 'add';
            submitFuncbtns();
        }
        function delAdress(el) {
            const action = document.getElementById('action');
            action.value = 'del' + el.id;
            submitFuncbtns();

        }
        function submitFuncbtns() {
            document.getElementById('thatForm').submit();
        }
    </script>
</head>

<body>
    <header>
        <div class="info_part">

        </div>
        <nav>
            <a href="orders.php" class="nav_item">Заказы</a>
            <?php
            $conn = mysqli_connect('localhost', 'root', 'mysql', 'MetroServis');
            $user_permission = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = \"" . intval($_COOKIE['id']) . "\" LIMIT 1")))['position'];
            if ($user_permission === 'Руководитель') {
                echo ('
                <a href="aboutUs_options.php" class="nav_item">Настройки</a>
                <a href="users.php" class="nav_item">Пользователи</a>
                ');
            }
            ?>
            <a href="profile.php" class="nav_item">Профиль</a>
        </nav>
    </header>
    <?php
    $conn = mysqli_connect('localhost', 'root', 'mysql', 'MetroServis');
    $user_permission = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = \"" . intval($_COOKIE['id']) . "\" LIMIT 1")))['position'];
    if ($user_permission != 'Руководитель') {
        header('Location: profile.php');
        exit();
    }
    $result = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT * FROM company_info'));
    $name = $result['name'];
    $short_name = $result['short_name'];
    $ver_acred = $result['ver_acred'];
    $syph_pover = $result['syph_pover'];

    ?>

    <div class="space">
        <div class="content">
            <form id="thatForm" class="reg_auth_form" action="aboutUs_update.php" method="POST">
                <label for="fname">Полное название организации:
                    <input id="fname" name="fname" type="text" value="<?php echo ($name) ?>">
                </label>
                <label for="sname">Соркащенное название организации:
                    <input id="sname" name="sname" type="text" value="<?php echo ($short_name) ?>">
                </label>
                <label for="adress">Адресса:
                    <input name="action" id="action" type="hidden" value="Save">
                    <div class="adress_container">
                        <input type="button" value="+" onclick="addAdress()">
                        <div class="adress_string">
                            <input form="thatForm" name="adress<?php foreach ($conn->query('SELECT id FROM adres WHERE id = (SELECT MIN(id) FROM adres LIMIT 1)') as $row) {
                                    echo ($row['id']);
                                } ?>" id="adress"
                                value="<?php foreach ($conn->query('SELECT adres FROM adres WHERE id = (SELECT MIN(id) FROM adres LIMIT 1)') as $row) {
                                    echo ($row['adres']);
                                } ?>"
                                name="adress" type="text"><?php
                                foreach ($conn->query('SELECT * FROM adres WHERE id > (SELECT MIN(id) FROM adres LIMIT 1)') as $row) {
                                    echo ('<div><input form="thatForm" id="adress" name="adress'.$row['id'].'" type="text" value="' . $row['adres'] . '"><input id="' . $row['id'] . '" type="button" value="-" onclick="delAdress(this)"></div>');
                                }

                                ?>
                        </div>
                    </div>
                </label>
                <label for="ver_acred">Аттестат акредитации:
                    <input id="ver_acred" name="ver_acred" type="text" value="<?php echo ($ver_acred) ?>">
                </label>
                <label for="syph_pover">Шифр поверительного клейма:
                    <input id="syph_pover" name="syph_pover" type="text" placeholder="XXX" maxlength="3"
                        value="<?php echo ($syph_pover) ?>">
                </label>
                <input type="submit" value="Сохранить">
            </form>
        </div>
    </div>
    <input type="text" order_num="">
    <script>
        $('#syph_pover').on('keypress', function () {
            var that = this;

            setTimeout(function () {
                var res = /[^А-Я ]/g.exec(that.value);
                console.log(res);
                that.value = that.value.replace(res, '');
            }, 0);
        });
    </script>

</body>

</html>