<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php session_start(); ?>
    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>

                        <form action="registercode.php" method="POST" enctype="multipart/form-data" >
                        <div class="form-group">
    
                                <label for="name"></label>
                                <input type="text" name="id" required placeholder="Id Number"/>
                            </div>
                            <div class="form-group">
                                <label for="name"></label>
                                <input type="text" name="fname" required placeholder="Your First Name"/>
                            </div>
                            <div class="form-group">
                                <label for="name"></label>
                                <input type="text" name="mname" required placeholder="Your Middle Name"/>
                            </div>
                            <div class="form-group">
                                <label for="name"></label>
                                <input type="text" name="lname" required placeholder="Your Last Name"/>
                            </div>
                            <div class="form-group">
                                <label for="email"></label>
                                <input type="email" name="email" required placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"></label>
                                <input type="password" name="password" required placeholder="Password"/>
                            </div>

                            <div class="form-group">
                                <label for="pass"></label>
                                <input type="password" name="confirm_password" required placeholder="Repeat your password"/>
                            </div>

                            <div class="form-group">
                                <label for=""></label>
                                <input type="text" name="mobilenumber" required placeholder="Mobile Number"/>
                            </div>

                            <div class="form-group">
                            <label for=""></label>
                                <input type="file" name="front"  accept=".jpg, .jpeg, .png" value="">Upload Front of School Id
                            </div>

                            <div class="form-group">
                            <label for=""></label>
                                <input type="file" name="back"  accept=".jpg, .jpeg, .png" value="">Upload Back of School Id
                            </div>
                            
                            <div class="form-group form-button">
                                <input type="submit" name="registerstudent_btn"  class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/ssg.jpg" alt="sing up image"></figure>
                        <a href="index.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>


    </div>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>

    
     <!-- SCRIPT FOR SWEET ALERT -->


  


<?php
        if(isset($_SESSION['status']) && $_SESSION['status_code'] !='' )
        {
            ?>
                <script>
                swal({
                title: "<?php echo $_SESSION['status']; ?>",
                icon: "<?php echo $_SESSION['status_code']; ?>",
                timer: 5000,
                button: "Close",
                }).then(
                function () {},
                // handling the promise rejection
                function (dismiss) {
                    if (dismiss === 'timer') {
                    //console.log('I was closed by the timer')
                    }
                }
                )
                </script>
                <?php
                unset($_SESSION['status']);
                unset($_SESSION['status_code']);
        }
                ?>

</body>
</html>