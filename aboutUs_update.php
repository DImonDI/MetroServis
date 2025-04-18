<?
$link = mysqli_connect('localhost', 'root', 'mysql', 'MetroServis');
$action = $_POST['action'];
if ($action === 'Save'){
    $query = mysqli_query($link,
    'UPDATE company_info 
    SET name="'.$_POST['name'].'", 
    short_name="'.$_POST['short_name'].'", 
    ver_acred="'.$_POST['ver_acred'].'", 
    syph_pover="'.$_POST['syph_pover'].'"');
} elseif ($action === 'del') {
    $query = 'INSERT INTO `adres` (`id`, `adres`) VALUES (NULL, "")';
} else {
    
}
?>