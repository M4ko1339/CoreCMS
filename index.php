<?php

include('header.php');

?>

<div class="container">
    <div class="row">
        <div class="content col s12">
            <div class="top-menu">
                <?php if(isset($_GET['edit']) || isset($_GET['action'])): ?>
                    <a href="index.php" class="btn back-button"><i class="fas fa-chevron-left"></i></a>
                <?php endif; ?>

                <?php if($perms->Access($_SESSION['username'], 'notify_create')): ?>
                    <a href="?action=newnotification" class="btn">New Notification</a>
                <?php endif; ?>

                <a href="options.php" class="btn icon-button right"><i class="fas fa-cog"></i></a>
                <a href="logs.php" class="btn icon-button right"><i class="fas fa-archive"></i></a>
            </div>
        </div>

        <?php if($perms->Access($_SESSION['username'], 'notify_view')): ?>
            <?php if(isset($_GET['action']) && $_GET['action'] == "newnotification" && $perms->Access($_SESSION['username'], 'notify_create')): ?>
                <div class="content col s12">
                    <div class="content-header col s12">
                        Create a new notification
                    </div>

                    <div class="content-box col s12">
                        <form method="POST">
                            <div class="input-field col s12">
                                <label>Color</label>
                                <br>
                                <p>
                                    <label>
                                        <input class="with-gap" type="radio" name="color" value="green" />
                                        <span>Green</span>
                                    </label>

                                    <label>
                                        <input class="with-gap" type="radio" name="color" value="orange" />
                                        <span>Orange</span>
                                    </label>

                                    <label>
                                        <input class="with-gap" type="radio" name="color" value="red" />
                                        <span>Red</span>
                                    </label>
                                </p>
                            </div>

                            <div class="input-field col s12">
                                <label>Message</label>
                                <input type="text" name="message" />
                            </div>

                            <div class="input-field col s12">
                                <input type="submit" name="create" class="btn" value="Create" />
                            </div>
                        </form>
                    </div>
                    <?php if(isset($_POST['create']) && $perms->Access($_SESSION['username'], 'notify_create')): ?>
                        <?php if(!empty($_POST['color']) && !empty($_POST['message'])): ?>
                            <?php $notify->Create($_POST['color'], $_POST['message']); ?>
                            <div class="response col s12 green">
                                Successfully created notification!
                            </div>
                        <?php else: ?>
                            <div class="response col s12 red">
                                Please fill in all fields!
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php elseif(isset($_GET['toggle']) && $notify->Exist((int)$_GET['toggle']) && $perms->Access($_SESSION['username'], 'notify_toggle')): ?>
                <?php

                $notify->Toggle($_GET['toggle']);
                header('Location: index.php');
                exit;

                ?>
            <?php elseif(isset($_GET['edit']) && $notify->Exist((int)$_GET['edit']) && $perms->Access($_SESSION['username'], 'notify_edit')): ?>
                <?php foreach($notify->View((int)$_GET['edit']) as $row): ?>
                    <div class="content col s12">
                        <div class="content-header col s12">
                            Modifying notification
                        </div>

                        <div class="content-box col s12">
                            <form method="POST">
                                <div class="input-field col s12">
                                    <label>Color</label>
                                    <br>
                                    <p>
                                        <label>
                                            <input class="with-gap" type="radio" name="color" value="green" <?php echo ($row['type'] == "green") ? "checked" : ""; ?> />
                                            <span>Green</span>
                                        </label>

                                        <label>
                                            <input class="with-gap" type="radio" name="color" value="orange" <?php echo ($row['type'] == "orange") ? "checked" : ""; ?> />
                                            <span>Orange</span>
                                        </label>

                                        <label>
                                            <input class="with-gap" type="radio" name="color" value="red" <?php echo ($row['type'] == "red") ? "checked" : ""; ?> />
                                            <span>Red</span>
                                        </label>
                                    </p>
                                </div>

                                <div class="input-field col s12">
                                    <label>Message</label>
                                    <input type="text" name="message" value="<?php echo $row['message']; ?>" />
                                </div>

                                <div class="input-field col s12">
                                    <input type="submit" name="edit" class="btn" value="Confirm" />
                                </div>
                            </form>
                        </div>
                    <?php endforeach; ?>

                    <?php if(isset($_POST['edit']) && $perms->Access($_SESSION['username'], 'notify_edit')): ?>
                        <?php if(!empty($_POST['message'])): ?>
                            <?php $notify->Edit((int)$_GET['edit'], $_POST['color'], $_POST['message']); ?>
                            <div class="response col s12 green">
                                Successfully modified notification!
                            </div>
                        <?php else: ?>
                            <div class="response col s12 red">
                                Please fill in all fields!
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php elseif(isset($_GET['delid']) && $notify->Exist((int)$_GET['delid']) && $perms->Access($_SESSION['username'], 'notify_delete')): ?>
                <?php
                    $notify->Delete((int)$_GET['delid']);
                    header('Location: index.php');
                    exit;
                ?>
            <?php elseif(isset($_GET['action']) && $_GET['action'] == "change-password"): ?>
                <div class="content col s12">
                    <div class="content-header col s12">
                        Change Password
                    </div>

                    <div class="content-box col s12">
                        <form method="POST">
                            <div class="input-field col s12">
                                <label>Old Password</label>
                                <input type="password" name="oldpassword" />
                            </div>

                            <div class="input-field col s12">
                                <label>New Password</label>
                                <input type="password" name="newpassword" />
                            </div>

                            <div class="input-field col s12">
                                <label>Re Password</label>
                                <input type="password" name="repassword" />
                            </div>

                            <div class="input-field col s12">
                                <input type="submit" name="change" class="btn" value="Change Password" />
                            </div>
                        </form>
                    </div>
                    <?php if(isset($_POST['change'])): ?>
                        <?php if(!empty($_POST['oldpassword']) && !empty($_POST['newpassword']) && !empty($_POST['repassword'])): ?>
                            <?php if($_POST['newpassword'] == $_POST['repassword']): ?>
                                <?php if($user->ChangePassword($_SESSION['username'], sha1($_POST['oldpassword'] . $user->Salt($_SESSION['username'])), $_POST['newpassword'])): ?>
                                    <div class="response col s12 green">
                                        Password has been changed!
                                    </div>
                                <?php else: ?>
                                    <div class="response col s12 red">
                                        Old password was incorrect!
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="response col s12 red">
                                    Passwords do not match!
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="response col s12 red">
                                Please fill in all fields!
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="content col s12 m9">
                    <table>
                        <th>Color</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th></th>
                        <th></th>
                        <th class="right"></th>

                        <?php foreach($notify->Show() as $row): ?>
                            <tr>
                                <td><?php echo ucfirst(strtolower($row['type'])); ?></td>
                                <td><?php echo $row['message']; ?></td>
                                <td><?php echo ($row['active']) ? "<span class='green-text'>Active</span>" : "<span class='red-text'>Inactive</span>"; ?></td>

                                <?php if($perms->Access($_SESSION['username'], 'notify_toggle')): ?>
                                    <td><a href="?toggle=<?php echo $row['id']; ?>"><i <?php echo ($row['active']) ? 'class="fas fa-toggle-on blue-text"' : 'class="fas fa-toggle-off blue-text"'; ?>></i></a></td>
                                <?php endif; ?>

                                <?php if($perms->Access($_SESSION['username'], 'notify_edit')): ?>
                                    <td><a href="?edit=<?php echo $row['id']; ?>"><i class="far fa-edit green-text"></i></a></td>
                                <?php endif; ?>

                                <?php if($perms->Access($_SESSION['username'], 'notify_delete')): ?>
                                    <td class="right"><a href="?delid=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');"><i class="fas fa-trash red-text"></i></a></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

                <div class="content col s12 m3">
                    <div class="content-box col s12">
                        <?php foreach($user->Info($_SESSION['username']) as $row): ?>
                            <div class="info-box">
                                <label>Username</label>
                                <div class="info-box-text">
                                    <?php echo ucfirst($row['username']); ?>
                                </div>
                            </div>

                            <div class="info-box">
                                <label>Email</label>
                                <div class="info-box-text">
                                    <?php echo $row['email']; ?>
                                </div>
                            </div>

                            <div class="info-box">
                                <label>Last IP</label>
                                <div class="info-box-text">
                                    <?php echo $row['last_ip']; ?>
                                </div>
                            </div>

                            <div class="info-box">
                                <label>Last Login</label>
                                <div class="info-box-text">
                                    <?php echo date('H:i - j. F, Y', $row['last_login']); ?>
                                </div>
                            </div>

                            <div class="input-field">
                                <a href="?action=change-email" class="btn info-button">Change Email</a>
                            </div>

                            <div class="input-field">
                                <a href="?action=change-password" class="btn info-button">Change Password</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="content col s12 m9">
                <div class="content-header col s12">
                    System Message
                </div>

                <div class="content-box col s12">
                    Welcome to the CoreCMS Administration Panel.
                </div>
            </div>
            <div class="content col s12 m3">
                <div class="content-box col s12">
                    <?php foreach($user->Info($_SESSION['username']) as $row): ?>
                        <div class="info-box">
                            <label>Username</label>
                            <div class="info-box-text">
                                <?php echo ucfirst($row['username']); ?>
                            </div>
                        </div>

                        <div class="info-box">
                            <label>Email</label>
                            <div class="info-box-text">
                                <?php echo $row['email']; ?>
                            </div>
                        </div>

                        <div class="info-box">
                            <label>Last IP</label>
                            <div class="info-box-text">
                                <?php echo $row['last_ip']; ?>
                            </div>
                        </div>

                        <div class="info-box">
                            <label>Last Login</label>
                            <div class="info-box-text">
                                <?php echo date('H:i - j. F, Y', $row['last_login']); ?>
                            </div>
                        </div>

                        <div class="input-field">
                            <a href="#" class="btn info-button">Change Email</a>
                        </div>

                        <div class="input-field">
                            <a href="#" class="btn">Change Password</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php

include('footer.php');

?>
