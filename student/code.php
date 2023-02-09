<?php
include('authentication.php');
?>

<?php
if(isset($_POST['logout_btn']))
{
    // session_destroy();
    unset( $_SESSION['auth']);
    unset( $_SESSION['auth_role']);
    unset( $_SESSION['auth_user']);

    $_SESSION['status'] = "Logout Successfully";
    $_SESSION['status_code'] = "success";
    header("Location: ../login/index.php");
    exit(0);
}
?>

<?php

if(isset($_POST['downloadqr']))
{
    $downloadqr= $_POST['downloadqr'];

    
$sql = "SELECT fee_qr FROM qrcode WHERE id='$downloadqr'";
$result = $con->query($sql);


if ($result->num_rows > 0) {
    // output data of the specific row
    while($row = $result->fetch_assoc()) {
        $image = $row["fee_qr"];
        $file = "image.png";
        file_put_contents($file, $image);
    }
} else {
    echo "0 results";
}
}


?>





<?php
if(isset($_POST['penalty']))
{
    $user_id= $_POST['user_id'];
    $rn= $_POST['rn'];
    $date= $_POST['date'];
    $receipt = addslashes(file_get_contents($_FILES["receipt"]['tmp_name']));

    $query = "INSERT INTO `payment`(`student`, `referencenumber`, `picture`, `date`) VALUES ('$user_id','$rn','$receipt','$date')";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Payment delivered to SSG!";
        $_SESSION['status_code'] = "success";
        header('Location: index.php');
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something is wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: index.php');
        exit(0);
    }
}
?>