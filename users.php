<?php

include('header.php');

$user = new User();

if(!$perms->Access($_SESSION['username'], 'user_view'))
{
    header('Location: index.php');
    exit;
}

$permissions = array(
    // General AdminCP
    'login'        => isset($_POST['login_access']) ? $_POST['login_access'] : "0",
    'logs_view'    => isset($_POST['logs_access']) ? $_POST['logs_access'] : "0",
    'options_view' => isset($_POST['options_access']) ? $_POST['options_access'] : "0",

    // News System
    'news_view'   => isset($_POST['news_access']) ? $_POST['news_access'] : "0",
    'news_post'   => isset($_POST['news_post']) ? $_POST['news_post'] : "0",
    'news_edit'   => isset($_POST['news_edit']) ? $_POST['news_edit'] : "0",
    'news_delete' => isset($_POST['news_delete']) ? $_POST['news_delete'] : "0",

    // User System
    'user_view'   => isset($_POST['user_access']) ? $_POST['user_access'] : "0",
    'user_create' => isset($_POST['user_create']) ? $_POST['user_create'] : "0",
    'user_reset'  => isset($_POST['user_reset']) ? $_POST['user_reset'] : "0",
    'user_edit'   => isset($_POST['user_edit']) ? $_POST['user_edit'] : "0",
    'user_ban'    => isset($_POST['user_ban']) ? $_POST['user_ban'] : "0",
    'user_delete' => isset($_POST['user_delete']) ? $_POST['user_delete'] : "0",

    // Notification System
    'notify_view'   => isset($_POST['notify_access']) ? $_POST['notify_access'] : "0",
    'notify_create' => isset($_POST['notify_create']) ? $_POST['notify_create'] : "0",
    'notify_toggle' => isset($_POST['notify_toggle']) ? $_POST['notify_toggle'] : "0",
    'notify_edit'   => isset($_POST['notify_edit']) ? $_POST['notify_edit'] : "0",
    'notify_delete' => isset($_POST['notify_delete']) ? $_POST['notify_delete'] : "0",
);

?>

<div class="container">
    <div class="row">
        <div class="content col s12">
            <div class="top-menu">
                <?php if(isset($_GET['edit']) || isset($_GET['action'])): ?>
                    <a href="users.php" class="btn back-button"><i class="fas fa-chevron-left"></i></a>
                <?php endif; ?>
                <?php if($perms->Access($_SESSION['username'], 'user_create')): ?>
                    <a href="?action=newuser" class="btn">New User</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="content col s12">
            <?php if(isset($_GET['action']) && $_GET['action'] == "newuser" && $perms->Access($_SESSION['username'], 'user_create')): ?>
                <div class="content-header col s12">
                    Create a new user
                </div>

                <div class="content-box col s12">
                    <form method="POST">
                        <div class="input-field col s12">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" />
                        </div>

                        <div class="input-field col s12">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" />
                        </div>

                        <div class="input-field col s12">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" />
                        </div>

                        <div class="input-field col s12">
                            <label for="repassword">Re Password</label>
                            <input type="password" id="repassword" name="repassword" />
                        </div>

                        <div class="input-field col s12">
                            <fieldset>
                                <legend>General Permissions</legend>
                                <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" name="login_access" value="1" />
                                        <span>Login Access</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="logs_access" value="1" />
                                        <span>Logs Access</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="options_access" value="1" />
                                        <span>Options Access</span>
                                    </label>
                                </p>
                            </fieldset>

                            <fieldset>
                                <legend>News Permissions</legend>
                                <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" name="news_access" value="1"/>
                                        <span>View News</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="news_post" value="1" />
                                        <span>Post News</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="news_edit" value="1" />
                                        <span>Edit News</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="news_delete" value="1" />
                                        <span>Delete News</span>
                                    </label>
                                </p>
                            </fieldset>

                            <fieldset>
                                <legend>Users Permissions</legend>
                                <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" name="user_access" value="1" />
                                        <span>View Users</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="user_create" value="1" />
                                        <span>Create Users</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="user_reset" value="1" />
                                        <span>Reset Users</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="user_edit" value="1" />
                                        <span>Edit Users</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="user_ban" value="1" />
                                        <span>Ban Users</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="user_delete" value="1" />
                                        <span>Delete Users</span>
                                    </label>
                                </p>
                            </fieldset>

                            <fieldset>
                                <legend>Notification Permissions</legend>
                                <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" name="notify_access" value="1" />
                                        <span>View Notifications</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="notify_create" value="1" />
                                        <span>Create Notifications</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="notify_toggle" value="1" />
                                        <span>Toggle Notifications</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="notify_edit" value="1" />
                                        <span>Edit Notifications</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="notify_delete" value="1" />
                                        <span>Delete Notifications</span>
                                    </label>
                                </p>
                            </fieldset>
                        </div>

                        <div class="input-field col s12">
                            <input type="submit" name="create" class="btn" value="Create" />
                        </div>
                    </form>
                </div>

                <?php if(isset($_POST['create']) && $perms->Access($_SESSION['username'], 'user_create')): ?>
                    <?php if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repassword'])): ?>
                        <?php if(!$user->Duplicate($_POST['username'], $_POST['email'])): ?>
                            <?php $user->Create($_POST['username'], $_POST['password'], $_POST['email'], $perms->Fetch($permissions)); ?>
                            <div class="response col s12 green">
                                User has been created!
                            </div>
                        <?php else: ?>
                            <div class="response col s12 red">
                                Username or Email already exists!
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="response col s12 red">
                            Please fill in all fields!
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php elseif(isset($_GET['edit']) && $user->Exist($_GET['edit']) && $perms->Access($_SESSION['username'], 'user_edit')): ?>
                <?php
                    $access = $perms->Get((int)$_GET['edit']);
                    foreach($user->View((int)$_GET['edit']) as $row)
                    {
                        $email = $row['email'];
                    }
                ?>
                <div class="content-header col s12">
                    Updating user
                </div>

                <div class="content-box col s12">
                    <form method="POST">
                        <div class="input-field col s12">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" value="<?php echo $email; ?>" />
                        </div>

                        <div class="input-field col s12">
                            <fieldset>
                                <legend>General Permissions</legend>
                                <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" name="login_access" <?php echo ($access['login'] ? "checked":""); ?> value="1" />
                                        <span>Login Access</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="logs_access" <?php echo ($access['logs_view'] ? "checked":""); ?> value="1" />
                                        <span>Logs Access</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="options_access" <?php echo ($access['options_view'] ? "checked":""); ?> value="1" />
                                        <span>Options Access</span>
                                    </label>
                                </p>
                            </fieldset>

                            <fieldset>
                                <legend>News Permissions</legend>
                                <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" name="news_access" <?php echo ($access['news_view'] ? "checked":""); ?> value="1"/>
                                        <span>View News</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="news_post" <?php echo ($access['news_post'] ? "checked":""); ?> value="1" />
                                        <span>Post News</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="news_edit" <?php echo ($access['news_edit'] ? "checked":""); ?> value="1" />
                                        <span>Edit News</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="news_delete" <?php echo ($access['news_delete'] ? "checked":""); ?> value="1" />
                                        <span>Delete News</span>
                                    </label>
                                </p>
                            </fieldset>

                            <fieldset>
                                <legend>Users Permissions</legend>
                                <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" name="user_access" <?php echo ($access['user_view'] ? "checked":""); ?> value="1" />
                                        <span>View Users</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="user_create" <?php echo ($access['user_create'] ? "checked":""); ?> value="1" />
                                        <span>Create Users</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="user_reset" <?php echo ($access['user_reset'] ? "checked":""); ?> value="1" />
                                        <span>Reset Users</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="user_edit" <?php echo ($access['user_reset'] ? "checked":""); ?> value="1" />
                                        <span>Edit Users</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="user_ban" <?php echo ($access['user_ban'] ? "checked":""); ?> value="1" />
                                        <span>Ban Users</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="user_delete" <?php echo ($access['user_delete'] ? "checked":""); ?> value="1" />
                                        <span>Delete Users</span>
                                    </label>
                                </p>
                            </fieldset>

                            <fieldset>
                                <legend>Notification Permissions</legend>
                                <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" name="notify_access" <?php echo ($access['notify_view'] ? "checked":""); ?> value="1" />
                                        <span>View Notifications</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="notify_create" <?php echo ($access['notify_create'] ? "checked":""); ?> value="1" />
                                        <span>Create Notifications</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="notify_toggle" <?php echo ($access['notify_toggle'] ? "checked":""); ?> value="1" />
                                        <span>Toggle Notifications</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="notify_edit" <?php echo ($access['notify_edit'] ? "checked":""); ?> value="1" />
                                        <span>Edit Notifications</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" name="notify_delete" <?php echo ($access['notify_delete'] ? "checked":""); ?> value="1" />
                                        <span>Delete Notifications</span>
                                    </label>
                                </p>
                            </fieldset>
                        </div>

                        <div class="input-field col s12">
                            <input type="submit" name="edit" class="btn" value="Confirm" />
                        </div>
                    </form>
                </div>

                <?php if(isset($_POST['edit']) && $perms->Access($_SESSION['username'], 'user_edit')): ?>
                    <?php if(!empty($_POST['email'])): ?>
                        <?php $user->Edit((int)$_GET['edit'], $_POST['email'], $perms->Fetch($permissions)); ?>
                        <div class="response col s12 green">
                            User has been updated!
                        </div>
                    <?php else: ?>
                        <div class="response col s12 red">
                            Email cannot be blank!
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php elseif(isset($_GET['delid']) && $user->Exist($_GET['delid']) && $perms->Access($_SESSION['username'], 'user_delete')): ?>
                <?php
                    $user->Delete((int)$_GET['delid']);
                    header('Location: users.php');
                    exit;
                ?>
            <?php else: ?>
                <table class="responsive-table">
                    <th>Username</th>
                    <th>Email</th>
                    <th>Last IP</th>
                    <th>Last Login</th>
                    <th></th>
                    <th class="right"></th>

                    <?php foreach($user->Show() as $row): ?>
                        <tr>
                            <td><?php echo ucfirst($row['username']); ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['last_ip']; ?></td>
                            <td><?php echo date('H:i - j. F, Y', $row['last_login']); ?></td>

                            <?php if($perms->Access($_SESSION['username'], 'user_edit')): ?>
                                <td><a href="?edit=<?php echo $row['id']; ?>"><i class="far fa-edit green-text"></i></a></td>
                            <?php endif; ?>

                            <?php if($perms->Access($_SESSION['username'], 'user_delete')): ?>
                                <td class="right"><a href="?delid=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');"><i class="fas fa-trash red-text"></i></a></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <ul class="pages">
                    <li><a href="#"><i class="fas fa-chevron-left"></i></a></li>
                    <li><a href="#" class="current-nav">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i></a></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php

include('footer.php');

?>
