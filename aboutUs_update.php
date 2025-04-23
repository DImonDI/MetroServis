<?
$conn = mysqli_connect('localhost', 'root', 'mysql', 'MetroServis');
$action = $_POST['action'];
echo($_POST['adress1']);
if ($action === 'Save'){
    mysqli_query($conn,
    'UPDATE company_info 
    SET name="'.$_POST['fname'].'", 
    short_name="'.$_POST['sname'].'", 
    ver_acred="'.$_POST['ver_acred'].'", 
    syph_pover="'.$_POST['syph_pover'].'"');
    foreach ($conn->query("SELECT * FROM adres") as $row){
        mysqli_query($conn,'UPDATE adres SET adres ="'.$_POST["adress".$row['id']].'" WHERE id = '.$row['id']);
    }
} elseif ($action === 'add') {
    mysqli_query($conn, 'INSERT INTO `adres` (`id`, `adres`) VALUES (NULL, "")');
} else {
    $id = str_replace('del', '', $action);
    mysqli_query($conn,"DELETE FROM adres WHERE id = $id");
}
header('Location: aboutUs_options.php'); exit;
?>