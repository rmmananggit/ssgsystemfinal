<?php
include('authentication.php');
?>


<?php
if(isset($_POST['add_expense']))
{

    $date = new DateTime();
    $date->setTimezone(new DateTimeZone('UTC'));
    $date_added = $date->format('Y-m-d H:i:s');


    $user_id = $_POST['user_id'];
    $purpose = $_POST['purpose'];
    $amount = $_POST['amount'];

    $query = "INSERT INTO `ssg_expenses`( `user`, `purpose`, `amount`, `date`) VALUES ('$user_id','$purpose','$amount','$date_added')";
    $query_run = mysqli_query($con, $query);

    if($query_run){
        $_SESSION['status'] = "Expenses Added";
        $_SESSION['status_code'] = "success";
        header('Location: liquidation.php');
        exit(0);
      }else{
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: liquidation.php');
        exit(0);
      }

}
?>


<?php
if(isset($_POST['update_student']))
{
    $user_id= $_POST['user_id'];
    $id= $_POST['id'];
    $fname= $_POST['fname'];
    $mname= $_POST['mname'];
    $lname= $_POST['lname'];
    $email= $_POST['email'];
    $mobilenumber= $_POST['mobilenumber'];

    $query = "UPDATE `student` SET `fname`='$fname',`mname`='$mname',`lname`='$lname',`email`='$email',`mobilenumber`='$mobilenumber',`id`='$id' WHERE `user_id`='$user_id'";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Student Information Updated";
        $_SESSION['status_code'] = "success";
        header('Location: student_account.php');
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something is wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: student_account.php');
        exit(0);
    }
}
?>



<?php
if(isset($_POST['user_delete']))
{
    $user_id= $_POST['user_delete'];

    $query = "DELETE FROM users WHERE id='$user_id'";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['message'] = "User Deleted Successfully";
        header('Location: view_register.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something went wrong!";
        header('Location: view_register.php');
        exit(0);
    }
}
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
//add officer account
if(isset($_POST["add_officer"])){
  $front = $_FILES['front'];
  $back = $_FILES['back'];

  $fileName = $front['name'];
  $fileTmpname = $front['tmp_name'];
  $fileSize = $front['size'];
  $fileError = $front['error'];

  $fileExt = explode('.',$fileName);
  $fileActExt = strtolower(end($fileExt));
  $allowed = array('jpg','jpeg','png');

  $fileName1 = $back['name'];
  $fileTmpname1 = $back['tmp_name'];
  $fileSize1 = $back['size'];
  $fileError1 = $back['error'];

  $fileExt1 = explode('.',$fileName1);
  $fileActExt1 = strtolower(end($fileExt1));
  $allowed1 = array('jpg','jpeg','png');



  if(in_array($fileActExt, $allowed)){
    if($fileError === 0){
        if($fileSize < 50000000){
          $fname = $_POST['fname'];
          $mname = $_POST['mname'];
          $lname = $_POST['lname'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          $position = $_POST['role_as'];

          $user_type = 1;
          $status = 1;
          $front = addslashes(file_get_contents($_FILES["front"]['tmp_name']));
          $back = addslashes(file_get_contents($_FILES["back"]['tmp_name']));

          $query = "INSERT INTO `user`(`fname`, `mname`, `lname`, `email`, `password`, `front`, `back`, `user_type`, `pos_name`, `user_status`) VALUES ('$fname','$mname','$lname','$email','$password','$front','$back','$user_type','$position','$status')";

            $query_run = mysqli_query($con, $query);

            if($query_run){
              $_SESSION['status'] = "Officer Account Added!";
              $_SESSION['status_code'] = "success";
              header('Location: officer_account.php');
              exit(0);
            }else{
              $_SESSION['status'] = "Product Not Added!";
              $_SESSION['status_code'] = "error";
              header('Location: manage_product.php');
              exit(0);
            }

        }else{
            $_SESSION['status']="File is too large file must be 10mb";
            $_SESSION['status_code'] = "error"; 
            header('Location: manage_product.php');
        }
    }else{
        $_SESSION['status']="File Error";
        $_SESSION['status_code'] = "error"; 
        header('Location: manage_product.php');
    }
}else{
    $_SESSION['status']="File not allowed";
    $_SESSION['status_code'] = "error"; 
    header('Location: manage_product.php');
}

}
?>

<?php
if(isset($_POST['payfines_btn']))
{
    $id = $_POST['user_id'];
    $payment = $_POST['pay'];
    $date = date('Y-m-d', strtotime($_POST['date']));


    $query= "SELECT fines, balance FROM student WHERE user_id = '$id' ";
    $query_run = $con->query($query);
    $data = $query_run->fetch_assoc();
    $fee = $data['fines'];
      

    if($data['balance'] > 0)
    {
        $query2 = "INSERT INTO `fines_transaction`(`fines_id`, `fines_fee`, `fines_date`) VALUES ('$id','$payment','$date')";
        $con->query($query2);
        
        $sq1 = "SELECT sum(fines_fee) as totalpaid FROM fines_transaction WHERE `fines_id` = '$id'";
        $sq1_run = $con->query($sq1);
        $row = $sq1_run->fetch_assoc();
        $totalpaid = $row['totalpaid'];
        $newbal = $fee - $totalpaid;

        $sq3 = "UPDATE `student` SET `balance`='$newbal' WHERE user_id = '$id'";
        $con->query($sq3);

        if($con)
        {
            {
                $_SESSION['status']="Successfully paid fines";
                $_SESSION['status_code'] = "success"; 
                header('Location: penaltyfee_view.php');
                exit(0);
            }
        }
        else
        {
            $_SESSION['status']="Something went wrong!";
            $_SESSION['status_code'] = "error"; 
            header('Location: penaltyfee_view.php');
            exit(0);
        }
    
    }
}else{
    $_SESSION['message'] = "Error! Something went wrong!";
    header('Location: fines.php');
    exit(0);
}

?>





