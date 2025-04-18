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

            $login = '';
            $password = '';
            $email = '';
            $snils = '';
            $client_data = '';
            $contact_person = '';
            $tel_num = '';
            $company_name = '';
            $position = 'Поверитель';

            if($_POST['selected_user'] > -1){
                $user_data = mysqli_fetch_assoc(mysqli_query($link,'SELECT * FROM users WHERE id="'.$_POST['selected_user'].'" LIMIT 1'));
                $login = $user_data['login'];
                $email = $user_data['email'];
                $snils = $user_data['SNILS'];
                $position = $user_data['position'];
                if ($position === 'Клиент'){
                    $client_data = mysqli_fetch_assoc(mysqli_query($link,'SELECT * FROM client_info WHERE user_id="'.$_POST['selected_user'].'" LIMIT 1'));
                    $contact_person = $client_data['contact_person'];
                    $tel_num = $client_data['tel_num'];
                    $company_name = $client_data['company_name'];
                }
           }
            
            ?>
            <a href="profile.php" class="nav_item">Профиль</a>
        </nav>
    </header>

    <div class="space">
        <div class="content">
            <form action="admins_user_control.php" class="reg_auth_form" method="POST">
                <label for="position">Должность: 
                    <select name="position" id="position">
                        <option value="Руководитель" <?php if($position === 'Руководитель'){echo('selected');}?>>Руководитель</option>
                        <option value="Поверитель" <?php if($position === 'Поверитель'){echo('selected');}?>>Поверитель</option>
                        <option value="Клиент" <?php if($position === 'Клиент'){echo('selected');}?>>Клиент</option>
                    </select>
                </label>
                <label for="login">Логин: 
                    <input name="login" id="login" type="text" value="<?php echo($login);?>" required>
                </label>
                <label for="password">Пароль: 
                    <input name="password" id="password" type="text" value="<?php echo($password);?>" required>
                </label>
                <label for="e-mail">Почта: 
                    <input name="e-mail" id="e-mail" type="text" value="<?php echo($email);?>" required>
                </label>
                <label class="not_client_info" for="snils">СНИЛС:
                    <input name="snils" id="snils" type="text" value="<?php echo($snils);?>">
                </label>
                <label class="hidden client_info1" for="contact_person">Контактное лицо (ФИО): 
                    <input name="contact_person" id="contact_person" type="text" value="<?php echo($contact_person);?>">
                </label>
                <label class="hidden client_info2" for="tel_num">Телефон: 
                    <input name="tel_num" id="tel_num" type="tel" placeholder="+7 (999) 999-99-99" value="<?php echo($tel_num);?>">
                </label>
                <label class="hidden client_info3" for="company_name">Название компании: 
                    <input name="company_name" id="company_name" type="text" value="<?php echo($company_name);?>">
                </label>
                <input name="selected_user" id="selected_user" type="hidden" value="<?php echo($_POST['selected_user']);?>">
                <input name="action_type" id="action_type" type="hidden" value=<?php echo($_POST['action_type'])?>>
                <input name="submit" type="submit" value="<?php echo($_POST['action_type'])?>">
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
        function StartSelect(){
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
        StartSelect();
        
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
<?
    $conn=mysqli_connect("localhost", "root", "mysql",  "MetroServis");

    $user_permission = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = \"".intval($_COOKIE['id'])."\" LIMIT 1")))['position'];
    if ($user_permission != 'Руководитель'){
        header('Location: profile.php'); exit();
    }
?>