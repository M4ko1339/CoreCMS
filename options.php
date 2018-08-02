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
                    <fieldset>
                        <legend>General Settings</legend>

                        <div class="input-field col s12">
                            <label for="name">Website Name</label>
                            <input type="text" id="name" name="name" value="" />
                        </div>

                        <div class="input-field col s12">
                            <label for="url">Website URL</label>
                            <input type="text" id="url" name="url" value="" />
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>ReCaptcha Settings</legend>

                        <div class="input-field col s12">
                            <label for="client">Client</label>
                            <input type="text" id="client" name="client" value="" />
                        </div>

                        <div class="input-field col s12">
                            <label for="secret">Secret</label>
                            <input type="text" id="secret" name="client" value="" />
                        </div>
                    </fieldset>

                    <div class="input-field col s12">
                        <input type="submit" class="btn" name="save" value="Save Settings" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

include('footer.php');

?>
