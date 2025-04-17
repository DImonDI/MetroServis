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
    <?
    $conn=mysqli_connect("localhost", "root", "mysql",  "MetroServis");

    $user_permission = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = \"".intval($_COOKIE['id'])."\" LIMIT 1")))['position'];
    if ($user_permission != 'Руководитель'){
        header('Location: profile.php'); exit();
    }
    if(isset($_POST['submit']))
    {
        $err = [];
        if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
        {
            $err[] = "Логин может состоять только из букв английского алфавита и цифр";
        }

        if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
        {
            $err[] = "Логин должен быть не меньше 5-и символов и не больше 30";
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
            $position = $_POST['position'];
            $snils = $position !== 'Клиент' ? $_POST['snils'] : 0;
            mysqli_query($conn,query: 'INSERT INTO users SET login="'.$login.'", password="'. $password .'", position="'. $position .'", email="' . $_POST['e-mail'] . '", SNILS="' . $snils . '"');
            if ($position === 'Клиент'){
                mysqli_query($conn,'INSERT INTO client_info SET user_id=(SELECT MAX(id) FROM users), contact_person="'.$_POST['contact_person'].'", tel_num="'.$_POST['tel_num'].'", company_name="'.$_POST['company_name'].'"');
            }
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

    <div class="space">
        <div class="content">
            <form class="reg_auth_form" method="POST">
                <label for="position">Должность: 
                    <select name="position" id="position">
                        <option value="Руководитель">Руководитель</option>
                        <option value="Поверитель" selected>Поверитель</option>
                        <option value="Клиент">Клиент</option>
                    </select>
                </label>
                <label for="login">Логин: 
                    <input name="login" id="login" type="text" required>
                </label>
                <label for="password">Пароль: 
                    <input name="password" id="password" type="text" required>
                </label>
                <label for="e-mail">Почта: 
                    <input name="e-mail" id="e-mail" type="text" required>
                </label>
                <label class="not_client_info" for="snils">СНИЛС:
                    <input name="snils" id="snils" type="text">
                </label>
                <label class="hidden client_info1" for="contact_person">Контактное лицо (ФИО): 
                    <input name="contact_person" id="contact_person" type="text"></label>
                <label class="hidden client_info2" for="tel_num">Телефон: 
                    <input name="tel_num" id="tel_num" type="tel" placeholder="+7 (999) 999-99-99">
                </label>
                <label class="hidden client_info3" for="company_name">Название компании: 
                    <input name="company_name" id="company_name" type="text">
                </label>
                <input name="submit" type="submit" value="Зарегистрировать">
                <a href="users.php">Вернуться</a>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
                Inputmask("+7 (999) 999-99-99'", {
                    placeholder: "-",
                    greedy: false,
                    jitMasking: true
                }).mask('#tel_num');

    
        });
        
        document.getElementById("position").onchange = function(){
            const client_info_field_1 = document.querySelector('label.client_info1');
            const client_info_field_2 = document.querySelector('label.client_info2');
            const client_info_field_3 = document.querySelector('label.client_info3');
            const not_client_info = document.querySelector('label.not_client_info');
            const contact_person = document.getElementById('contact_person');
            const tel_num = document.getElementById('tel_num');
            const company_name = document.getElementById('company_name');
            const snils = document.getElementById('snils');
            const position = document.getElementById('position');
            if (position.options[position.selectedIndex].text == 'Клиент' && (client_info_field_1.classList.contains('hidden'))){
                contact_person.setAttribute('required','true');
                tel_num.setAttribute('required','true');
                company_name.setAttribute('required','true');
                snils.removeAttribute('required');
                client_info_field_1.classList.remove('hidden');
                client_info_field_2.classList.remove('hidden');
                client_info_field_3.classList.remove('hidden');
                not_client_info.classList.add('hidden');
                
            } else if (position.options[position.selectedIndex].text != 'Клиент' && !(client_info_field_1.classList.contains('hidden'))){
                contact_person.removeAttribute('required');
                tel_num.removeAttribute('required');
                company_name.removeAttribute('required');
                snils.setAttribute('required','true');
                client_info_field_1.classList.add('hidden');
                client_info_field_2.classList.add('hidden');
                client_info_field_3.classList.add('hidden');
                not_client_info.classList.remove('hidden');

            }
        };

    </script>
</body>
</html>