<?php

session_start();

include('inc/db.php');
include('inc/functions.php');

$user = new User();

if(!$user->Authenticated())
{
    header('Location: login.php');
    exit;
}

$notify = new Notification();
$perms  = new Permissions();

?>
<html>
<head>
    <title>CoreCMS</title>
    <meta http-equiv="content-type" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">

    <!-- CSS Stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/materialize.min.css" media="screen,projection">
    <link rel="stylesheet" type="text/css" href="css/main.css" media="screen,projection">
    <link rel="stylesheet" type="text/css" href="css/content.css" media="screen,projection">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css" media="screen,projection">
</head>
<body>
<div class="topline">
    <div class="container">
        <div class="row">
            <div class="logo col m4">
                <a href="index.php">
                    Core<span class="green-text">CMS</span>
                </a>
            </div>

            <div class="menu col m8">
                <ul>
                    <li><a href="index.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "index.php" || "")?"class=\"current-nav\"":""; ?>><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>

                    <?php if($perms->Access($_SESSION['username'], 'news_view')): ?>
                        <li><a href="news.php"  <?php echo (basename($_SERVER["PHP_SELF"]) == "news.php")?"class=\"current-nav\"":""; ?>><i class="far fa-newspaper"></i> News</a></li>
                    <?php endif; ?>

                    <?php if($perms->Access($_SESSION['username'], 'user_view')): ?>
                        <li><a href="users.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "users.php")?"class=\"current-nav\"":""; ?>><i class="fas fa-users"></i> Users</a></li>
                    <?php endif; ?>

                    <li><a href="transactions.php" <?php echo (basename($_SERVER["PHP_SELF"]) == "transactions.php")?"class=\"current-nav\"":""; ?>><i class="fas fa-credit-card"></i> Transactions</a></li>

                    <li><a href="?logout=true" class="logout"><i class="fas fa-power-off"></i> Logout</a></li>

                    <?php

                    if(isset($_GET['logout']) && $_GET['logout'] == 'true')
                    {
                        $user->Logout();
                    }

                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php if($notify->Broadcast()): ?>
    <div class="container">
        <div class="row">
            <div class="notifications col s12">
                <?php foreach($notify->Broadcast() as $row): ?>
                    <div class="notification <?php echo $row['type']; ?>">
                        <?php echo $row['message']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
