<?
    $conn=mysqli_connect("localhost", "root", "mysql",  "MetroServis");
    $selecte_user = $_POST['selected_user'];
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
        $query = mysqli_query($conn, "SELECT id FROM users WHERE login='".$_POST['login']."'");
        if(mysqli_num_rows($query) > 0 and (mysqli_fetch_assoc($query)['id'] === -1 or mysqli_fetch_assoc($query)['id'] === $selecte_user))
        {
            $err[] = "Пользователь с таким логином уже существует в базе данных";
        }
        if(count($err) == 0)
        {
            $action_type = $_POST['action_type'];
            $login = $_POST['login'];
            $password = md5(md5(trim($_POST['password'])));
            $position = $_POST['position'];
            $snils = $position !== 'Клиент' ? $_POST['snils'] : 0;
            if($action_type === 'Зарегестрировать'){
                mysqli_query($conn,query: 'INSERT INTO users SET login="'.$login.'", password="'. $password .'", position="'. $position .'", email="' . $_POST['e-mail'] . '", SNILS="' . $snils . '"');
                if ($position === 'Клиент'){
                    mysqli_query($conn,'INSERT INTO client_info SET user_id=(SELECT MAX(id) FROM users), contact_person="'.$_POST['contact_person'].'", tel_num="'.$_POST['tel_num'].'", company_name="'.$_POST['company_name'].'"');
                }
            } else {
                mysqli_query($conn,query: 'UPDATE users SET login="'.$login.'", password="'. $password .'", position="'. $position .'", email="' . $_POST['e-mail'] . '", SNILS="' . $snils . '" WHERE id="'.$selecte_user.'"');
                if ($position === 'Клиент'){
                    mysqli_query($conn,'UPDATE client_info SET contact_person="'.$_POST['contact_person'].'", tel_num="'.$_POST['tel_num'].'", company_name="'.$_POST['company_name'].'" WHERE id="'.$selecte_user.'"');
                }
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
    header('Location: users.php'); exit();
    ?>
