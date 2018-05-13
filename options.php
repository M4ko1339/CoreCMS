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
            <div class="content-box col s12">
                <form method="POST">
                    <div class="input-field col s12">
                        <label>Website Name</label>
                        <input type="text" name="websitename" value="CoreCMS" />
                    </div>

                    <div class="input-field col s12">
                        <label>Website URL</label>
                        <input type="text" name="websitename" value="http://corecms.com" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

include('footer.php');

?>
