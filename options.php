<?php

include('header.php');

if(!$perms->Access($_SESSION['username'], 'options_view'))
{
    header('Location: index.php');
    exit;
}

?>

<div class="container">
    <div class="row">
        <div class="content col s12">
            <div class="top-menu">
                <a href="index.php" class="btn back-button"><i class="fas fa-chevron-left"></i></a>
            </div>
        </div>

        <div class="content col s12">

        </div>
    </div>
</div>

<?php

include('footer.php');

?>
