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

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" class="register-form" id="register-form">
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
                                <input type="password" name="pass" required placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"></label>
                                <input type="password" name="re_pass" required placeholder="Repeat your password"/>
                            </div>

                            <div class="form-group">
                            <label for="image"></label>
                                <input type="file" name="photo1" id="image" accept=".jpg, .jpeg, .png" value="">Upload Front of School Id
                            </div>

                            <div class="form-group">
                            <label for="image"></label>
                                <input type="file" name="photo1" id="image" accept=".jpg, .jpeg, .png" value="">Upload Back of School Id
                            </div>
                            
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
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

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>