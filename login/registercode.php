<?php
session_start();
include('../admin/config/dbcon.php');


if(isset($_POST['registerstudent_btn']))
{   
$id = mysqli_real_escape_string($con, $_POST['id']);
$fname = mysqli_real_escape_string($con, $_POST['fname']);
$mname = mysqli_real_escape_string($con, $_POST['mname']);
$lname = mysqli_real_escape_string($con, $_POST['lname']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
$mobilenumber = mysqli_real_escape_string($con, $_POST['mobilenumber']);
$user_type = 4;
$user_status = 1;
$fines = 0;
$balance = 0;
$front = addslashes(file_get_contents($_FILES["front"]['tmp_name']));
$back = addslashes(file_get_contents($_FILES["back"]['tmp_name']));

    if($password == $confirm_password){
        //check email
        $checkemail = "SELECT email FROM student WHERE email='$email'";
        $checkemail_run = mysqli_query($con,$checkemail);

        if(mysqli_num_rows($checkemail_run) > 0)
        {
          $_SESSION['status'] = "Email already exist!";
          $_SESSION['status_code'] = "error";
          header("Location: studentregister.php");
            exit(0);
        }
        else{
          $query = "INSERT INTO `student`(`fname`, `mname`, `lname`, `email`, `password`, `mobilenumber`, `id`, `front`, `back`, `user_type`, `user_status`, `fines`, `balance`) VALUES ('$fname,'$mname','$lname','$email','$password','$mobilenumber','$id','$front','$back','$user_type','$user_status','$fines','$balance')";
            $query_run = mysqli_query($con, $query);

            if($query_run)
            {
              $_SESSION['status'] = "Registered Succesfully";
              $_SESSION['status_code'] = "success";
              header('Location: index.php');
                exit(0);
            }
            else
            {

            }
        }

    }
    else
    {
      $_SESSION['status'] = "Password does not match!";
      $_SESSION['status_code'] = "success";
      header('Location: studentregister.php');
        exit(0);
    }
    
}



?>

   