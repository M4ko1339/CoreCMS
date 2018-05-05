<?php

session_start();

include('inc/db.php');
include('inc/functions.php');

$user  = new User();

if($user->Authenticated())
{
    header('Location: index.php');
    exit;
}

?>
<html>
<head>
    <title>CoreCMS - Login</title>
    <meta http-equiv="content-type" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">

    <!-- CSS Stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/materialize.min.css" media="screen,projection">
    <link rel="stylesheet" type="text/css" href="css/main.css" media="screen,projection">
    <link rel="stylesheet" type="text/css" href="css/login.css" media="screen,projection">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css" media="screen,projection">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="login col s12 m6 offset-m3 l4 offset-l4">
                <div class="login-box">
                    <div class="login-box-header">
                        CoreCMS - Login
                    </div>

                    <div class="login-box-content">
                        <form method="POST">
                            <div class="input-field">
                                <label>Username</label>
                                <input type="text" name="username" />
                            </div>

                            <div class="input-field">
                                <label>Password</label>
                                <input type="password" name="password" />
                            </div>

                            <div class="input-field">
                                <input type="submit" class="btn" name="login" value="Login" />
                            </div>
                        </form>
                    </div>
                </div>

                <?php if(isset($_POST['login'])): ?>
                    <?php if(!empty($_POST['username']) && !empty($_POST['password'])): ?>
                        <?php if($user->Login($_POST['username'], $_POST['password'] . $user->Salt($_POST['username']))): ?>
                            <?php
                                $_SESSION['username'] = $_POST['username'];
                                $_SESSION['password'] = sha1($_POST['password'] . $user->Salt($_POST['username']));

                                header('Location: index.php');
                                exit;
                            ?>
                        <?php else: ?>
                            <div class="response red">
                                Username or password was incorrect!
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="response red">
                            Please fill in all fields!
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.js"></script>
</body>
</html>
