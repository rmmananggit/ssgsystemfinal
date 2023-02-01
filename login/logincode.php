<?php
session_start();
include('../admin/config/dbcon.php');

if(isset($_POST['login_btn']))
{
    
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $login_query = "SELECT user_id,fname,lname,user_status,pos_name,user_type,email,password FROM user WHERE email='$email' AND password= '$password' 
     UNION
     SELECT user_id,fname,lname,user_status,pos_name,user_type,email,password FROM student WHERE email='$email' AND password= '$password' LIMIT 1";
    $login_query_run = mysqli_query($con, $login_query);

    if(mysqli_num_rows($login_query_run) > 0)
    {
        foreach($login_query_run as $data){
            $user_id = $data['user_id'];
            $full_name = $data['fname'].' '.$data['lname'];
            $u_status = $data['user_status'];
            $pos_as = $data['pos_name'];
            $role_as = $data['user_type'];
            $user_email = $data['email'];
        }

        $_SESSION['auth'] = true;
        $_SESSION['auth_role'] = "$role_as";
        $_SESSION['u_status'] = "$u_status";
        $_SESSION['pos_role'] = "$pos_as";
        $_SESSION['auth_user'] = [
            'user_id' =>$user_id,
            'user_name' =>$full_name,
            'user_email' =>$user_email,
        ];

            if($_SESSION['u_status'] != '3' && $_SESSION['u_status'] != '2')
            {
                if( $_SESSION['auth_role'] == '1' &&  $_SESSION['pos_role'] == '1'   )
        {
            $_SESSION['status'] = "Welcome Administrator";
            $_SESSION['status_code'] = "success";
            header("Location: ../admin/index.php");
            exit(0);
        }elseif( $_SESSION['auth_role'] == '5' &&  $_SESSION['pos_role'] == '4')
        {
            $_SESSION['status'] = "Welcome Parent!";
            $_SESSION['status_code'] = "success";
            header("Location: ../parent/index.php");
            exit(0);
        }
        elseif( $_SESSION['auth_role'] == '1' &&  $_SESSION['pos_role'] == '2')
        {
            $_SESSION['status'] = "Welcome Secretary!";
            $_SESSION['status_code'] = "success";
            header("Location: ../secretary/index.php");
            exit(0);
        }
        elseif( $_SESSION['auth_role'] == '1' &&  $_SESSION['pos_role'] == '3')
        {
            $_SESSION['status'] = "Welcome Treasurer!";
            $_SESSION['status_code'] = "success";
            header("Location: ../treasurer/index.php");
            exit(0);
        } elseif( $_SESSION['auth_role'] == '4'  &&  $_SESSION['pos_role'] == '5')
        {
            $_SESSION['status'] = "Welcome Student!";
            $_SESSION['status_code'] = "success";
            header("Location: ../student/index.php");
            exit(0);
        }
            }else{
                $_SESSION['status'] = "Your account is archived or pending";
            $_SESSION['status_code'] = "error";
            header("Location: ../login/index.php");
            exit(0);
            }
           

           
        }
        else{
            $_SESSION['status'] = "Invalid Username and Password";
            $_SESSION['status_code'] = "error";
            header("Location: ../login/index.php");
            exit(0);
        }
    }
    else
    {
        $_SESSION['status'] = "Invalid Username and Password";
        $_SESSION['status_code'] = "error";
        header("Location: ../login/index.php");
        exit(0);
    }   


?>

<!-- 

elseif( $_SESSION['auth_role'] == '5' &&  $_SESSION['pos_role'] == '4')
        {
            $_SESSION['status'] = "Welcome Parent!";
            $_SESSION['status_code'] = "success";
            header("Location: ../parent/index.php");
            exit(0);
        }
        elseif( $_SESSION['auth_role'] == '1' &&  $_SESSION['pos_role'] == '2')
        {
            $_SESSION['status'] = "Welcome Secretary!";
            $_SESSION['status_code'] = "success";
            header("Location: ../secretary/index.php");
            exit(0);
        }
        elseif( $_SESSION['auth_role'] == '1' &&  $_SESSION['pos_role'] == '3')
        {
            $_SESSION['status'] = "Welcome Treasurer!";
            $_SESSION['status_code'] = "success";
            header("Location: ../treasurer/index.php");
            exit(0);
        } -->
