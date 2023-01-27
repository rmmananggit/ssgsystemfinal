<?php
session_start();
include('../admin/config/dbcon.php');

if(isset($_POST['register_btn']))
{   
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


    if($password == $confirm_password){
        //check email
        $checkemail = "SELECT email FROM users WHERE email='$email'";
        $checkemail_run = mysqli_query($con,$checkemail);

        if(mysqli_num_rows($checkemail_run) < 0)
        {
            if(in_array($fileActExt, $allowed) && in_array($fileActExt1, $allowed1)){
                if($fileError === 0){
                    if($fileSize < 50000000){
          
                      $date = new DateTime();
                      $date->setTimezone(new DateTimeZone('UTC'));
                      $report_date = $date->format('Y-m-d H:i:s');
          
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
          
                      $photo = addslashes(file_get_contents($_FILES["photo"]['tmp_name']));
                      $photo1 = addslashes(file_get_contents($_FILES["photo1"]['tmp_name']));
          
                      $query = "INSERT INTO `student`(`fname`, `mname`, `lname`, `email`, `password`, `mobilenumber`, `id`, `front`, `back`, `user_type`, `user_status`, `fines`, `balance`) VALUES ('$fname,'$mname','$lname','$email','$password','$mobilenumber','$id','$front','$back','$user_type','$user_status','$fines','$balance')";
            
                        $query_run = mysqli_query($con, $query);
            
                        if($query_run){
                          $_SESSION['status'] = "Registered Succesfully";
                          $_SESSION['status_code'] = "success";
                          header('Location: index.php');
                          exit(0);
                        }else{
                          $_SESSION['status'] = "Something went wrong!";
                          $_SESSION['status_code'] = "error";
                          header('Location: index.php');
                          exit(0);
                        }
            
                    }else{
                        $_SESSION['status']="File is too large file must be 10mb";
                        $_SESSION['status_code'] = "error"; 
                        header('Location: index.php');
                    }
                }else{
                    $_SESSION['status']="File Error";
                    $_SESSION['status_code'] = "error"; 
                    header('Location: index.php');
                }
            }else{
              $_SESSION['status']="File Error";
              $_SESSION['status_code'] = "error"; 
              header('Location: index.php');
            }
        }
        else{

            }
        }

    }
    else
    {

     }







   