<?php
include('authentication.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';




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

  $email = $_POST['email'];

  $checkemail = "SELECT email FROM user WHERE email='$email'";
  $checkemail_run = mysqli_query($con,$checkemail);

  if(mysqli_num_rows($checkemail_run) > 0)
  {
    $_SESSION['status'] = "Email already exist!";
    $_SESSION['status_code'] = "error";
    header("Location: officer_account.php");
      exit(0);
  }
  else{
    if(in_array($fileActExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 50000000){
              $fname = $_POST['fname'];
              $mname = $_POST['mname'];
              $lname = $_POST['lname'];
              $email = $_POST['email'];
              $password = uniqid();
              $position = $_POST['role_as'];
              $code = 0;
              $user_type = 1;
              $status = 1;
              $front = addslashes(file_get_contents($_FILES["front"]['tmp_name']));
              $back = addslashes(file_get_contents($_FILES["back"]['tmp_name']));
    
              $query = "INSERT INTO `user`(`fname`, `mname`, `lname`, `email`, `password`, `front`, `back`, `user_type`, `pos_name`, `user_status`,`code`) VALUES ('$fname','$mname','$lname','$email','$password','$front','$back','$user_type','$position','$status','$code')";
    
                $query_run = mysqli_query($con, $query);
    
                if($query_run){
    
                    $name = htmlentities($_POST['lname']);
                    $email = htmlentities($_POST['email']);
                    $subject = htmlentities('Username and Password Credentials');
                    $message =  nl2br("Good day! \r\n This is your Online SSG Account! \r\n Email:\$email\ \r\n Password: \$password\ ");
                
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'ssg.jbi7204@gmail.com';
                    $mail->Password = 'fkqlcsiecymvoypb';
                    $mail->Port = 465;
                    $mail->SMTPSecure = 'ssl';
                    $mail->isHTML(true);
                    $mail->setFrom($email, $name);
                    $mail->addAddress($_POST['email']);
                    $mail->Subject = ("$email ($subject)");
                    $mail->Body = $message;
                    $mail->send();
      
    
                  $_SESSION['status'] = "Officer Account has been added, password is sent to their email.";
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
}




if(isset($_POST['update_announcement']))    
{

    $id = $_POST['announcement_id'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $publish = $_POST['publish'];
    $date = $_POST['date'];
    $status = "Active";

    $query = "UPDATE `announcement` SET `announcement_title`='$title]',`announcement_body`='$body',`announcement_publish`='$publish',`status`='$status',`announcement_date`='$date' WHERE announcement_id = '$id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run){
        $_SESSION['status'] = "Announcement Updated!";
        $_SESSION['status_code'] = "success";
        header('Location: announcement.php');
        exit(0);
      }else{
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: announcement.php');
        exit(0);
      }

}





if(isset($_POST['announcement_delete']))
{
    $user_id= $_POST['announcement_delete'];
    $newstatus = "Archived";

    $query = "UPDATE `announcement` SET `status`='$newstatus' WHERE `announcement_id`= '$user_id'";
    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
      $_SESSION['status'] = "The announcement has been successfully archived.";
      $_SESSION['status_code'] = "success";
      header('Location: announcement.php');
      exit(0);
    }
    else
    {
      $_SESSION['status'] = "SOMETHING WENT WRONG!";
      $_SESSION['status_code'] = "error";
      header('Location: announcement.php');
      exit(0);
    }
}


if(isset($_POST['add_ann']))
{
    $title = $_POST['title'];
    $body = $_POST['body'];
    $publish = $_POST['publish'];
    $date = $_POST['date'];
    $status = "Active";

    $query = "INSERT INTO `announcement`(`announcement_title`, `announcement_body`, `announcement_publish`,`status`, `announcement_date`) VALUES ('$title','$body','$publish','$status','$date')";
    $query_run = mysqli_query($con, $query);

    if($query_run){
        $_SESSION['status'] = "Announcement Added!";
        $_SESSION['status_code'] = "success";
        header('Location: announcement.php');
        exit(0);
      }else{
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: announcement.php');
        exit(0);
      }

}




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


if(isset($_POST['addfinesbtn']))
{
    $user_id= $_POST['user_id'];
    $fines = $_POST['addfines'];
   
    $q1= "SELECT fines, balance FROM student WHERE user_id = '$user_id' ";
    $q1_run = $con->query($q1);
    $data = $q1_run->fetch_assoc();
    $fee = $data['fines'];
    $bal = $data['balance'];

    $newfee = $fines + $fee;
    $newbal = $fines + $bal;

    $query = "UPDATE `student` SET `fines`='$newfee',`balance`='$newbal' WHERE `user_id` = '$user_id'";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Fee Added";
        $_SESSION['status_code'] = "success";
        header('Location: fines.php');
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something is wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: fines.php');
        exit(0);
    }
}



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




if(isset($_POST['update_officer']))
{
    $user_id= $_POST['user_id'];
    $fname= $_POST['fname'];
    $mname= $_POST['mname'];
    $lname= $_POST['lname'];
    $email= $_POST['email'];
    $password= $_POST['password'];
    $position = $_POST['position'];
    $status = $_POST['status'];
    $front = $_FILES['front'];
    $back = $_FILES['back'];
    $front = addslashes(file_get_contents($_FILES["front"]['tmp_name']));
    $back = addslashes(file_get_contents($_FILES["back"]['tmp_name']));

    $query = "UPDATE `user` SET `fname`='$fname',`mname`='$mname',`lname`='$lname',`email`='$email',`password`='$password',`front`='$front',`back`='$back' WHERE `user_id`='$user_id'";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Officer Update Succesfully";
        $_SESSION['status_code'] = "success";
        header('Location: officer_account.php');
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something is wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: officer_account.php');
        exit(0);
    }
}




if(isset($_POST['update_parent']))
{
    $user_id= $_POST['user_id'];
    $fname= $_POST['fname'];
    $mname= $_POST['mname'];
    $lname= $_POST['lname'];
    $email= $_POST['email'];
    $password= $_POST['password'];
    $position = $_POST['position'];
    $status = $_POST['status'];
    $front = $_FILES['front'];
    $back = $_FILES['back'];
    $front = addslashes(file_get_contents($_FILES["front"]['tmp_name']));
    $back = addslashes(file_get_contents($_FILES["back"]['tmp_name']));

    $query = "UPDATE `user` SET `fname`='$fname',`mname`='$mname',`lname`='$lname',`email`='$email',`password`='$password',`front`='$front',`back`='$back' WHERE `user_id`='$user_id'";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Officer Update Succesfully";
        $_SESSION['status_code'] = "success";
        header('Location: parent_account.php');
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something is wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: parent_account.php');
        exit(0);
    }
}





if(isset($_POST['student_active']))
{
    $user_id= $_POST['student_active'];
    $u_status = 1;

    $query = "UPDATE `student` SET `user_status`='$u_status' WHERE user_id='$user_id'";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Status change to Active";
        $_SESSION['status_code'] = "success";
        header('Location: index.php');
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: index.php');
        exit(0);
    }
}



if(isset($_POST['parent_active']))
{
    $user_id= $_POST['parent_active'];
    $status = 1;

    $query = "UPDATE `user` SET `user_status`='$status' WHERE user_id='$user_id'";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Parent Status change to active";
        $_SESSION['status_code'] = "success";
        header('Location: index.php');
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: index.php');
        exit(0);
    }
}


if(isset($_POST['parent_active']))
{
    $user_id= $_POST['parent_active'];
    $status = 1;

    $query = "UPDATE `user` SET `user_status`='$status' WHERE user_id='$user_id'";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Parent Account Status change to active";
        $_SESSION['status_code'] = "success";
        header('Location: index.php');
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: index.php');
        exit(0);
    }
}


if(isset($_POST['officer_active']))
{
    $user_id= $_POST['officer_active'];
    $status01 = 1;

    $query = "UPDATE `user` SET `user_status`='$status01' WHERE user_id='$user_id'";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Officer Account Status change to active";
        $_SESSION['status_code'] = "success";
        header('Location: index.php');
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: index.php');
        exit(0);
    }
}




if(isset($_POST['officer_delete']))
{
    $user_id= $_POST['officer_delete'];
    $u_status = 2;

    $query = "UPDATE `user` SET `user_status`='$u_status' WHERE user_id='$user_id'";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Officer Archived";
        $_SESSION['status_code'] = "success";
        header('Location: officer_account.php');
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: officer_account.php.php');
        exit(0);
    }
}



if(isset($_POST['parent_delete']))
{
    $user_id= $_POST['parent_delete'];
    $u_status = 2;

    $query = "UPDATE `user` SET `user_status`='$u_status' WHERE user_id='$user_id'";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Parent Archived";
        $_SESSION['status_code'] = "success";
        header('Location: parent_account.php');
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: parent_account.php.php');
        exit(0);
    }
}






if(isset($_POST['student_delete']))
{
    $user_id= $_POST['student_delete'];
    $u_status = 2;

    $query = "UPDATE `student` SET `user_status`='$u_status' WHERE `user_id`='$user_id'";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Student Archived";
        $_SESSION['status_code'] = "success";
        header('Location: student_account.php');
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: student_account.php.php');
        exit(0);
    }
}





if(isset($_POST['update_account']))
{

    $user_id= $_POST['user_id'];
    $fname= $_POST['fname'];
    $mname= $_POST['mname'];
    $lname= $_POST['lname'];
    $email= $_POST['email'];
    $password= $_POST['password'];
    $position = $_POST['position'];
    $status = $_POST['status'];

    $front = addslashes(file_get_contents($_FILES["front"]['tmp_name']));
    $back = addslashes(file_get_contents($_FILES["back"]['tmp_name']));

    $query = "UPDATE `user` SET `fname`='$fname',`mname`='$mname',`lname`='$lname',`email`='$email',`password`='$password',`front`='$front',`back`='$back' WHERE `user_id`='$user_id'";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['status'] = "Account Update Succesfully";
        $_SESSION['status_code'] = "success";
        header('Location: index.php');
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something is wrong!";
        $_SESSION['status_code'] = "error";
        header('Location: settings.php');
        exit(0);
    }
}

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
}







