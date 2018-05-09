<?php

include('header.php');

$user  = new User();
$perms = new Permissions();

$array = $perms->Get('test');

?>

<div class="container">
    <div class="row">
        <div class="content col s12">
            <div class="top-menu">
                <?php if(isset($_GET['edit']) || isset($_GET['action'])): ?>
                    <a href="users.php" class="btn back-button"><i class="fas fa-chevron-left"></i></a>
                <?php endif; ?>
                <a href="?action=newuser" class="btn">New User</a>
            </div>
        </div>

        <div class="content col s12">
            <?php if(isset($_GET['action']) && $_GET['action'] == "newuser"): ?>
                <div class="content-header col s12">
                    Create a new user
                </div>

                <div class="content-box col s12">
                    <form method="POST">
                        <div class="input-field col s12">
                            <label>Username</label>
                            <input type="text" name="username" />
                        </div>

                        <div class="input-field col s12">
                            <label>Email</label>
                            <input type="text" name="email" />
                        </div>

                        <div class="input-field col s12">
                            <label>Password</label>
                            <input type="password" name="password" />
                        </div>

                        <div class="input-field col s12">
                            <label>Re Password</label>
                            <input type="password" name="repassword" />
                        </div>

                        <div class="input-field col s12">
                            <fieldset>
                                <legend>General Permissions</legend>
                                <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" name="login_access" value="1" />
                                        <span>Login Access</span>
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
                        </div>

                        <div class="input-field col s12">
                            <input type="submit" name="create" class="btn" value="Create" />
                        </div>
                    </form>
                </div>

                <?php if(isset($_POST['create'])): ?>
                    <?php if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repassword'])): ?>
                        <?php if(!$user->Duplicate($_POST['username'], $_POST['email'])): ?>
                            <?php $user->Create($_POST['username'], $_POST['password'], $_POST['email'], $perms->Fetch(array(
                                // General AdminCP
                                'login'       => isset($_POST['login_access']) ? $_POST['login_access'] : "0",

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
                            ))); ?>
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
            <?php elseif(isset($_GET['edit']) && $user->Exist($_GET['edit'])): ?>

            <?php elseif(isset($_GET['delid']) && $user->Exist($_GET['delid'])): ?>

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
                            <td><?php echo ucfirst($row['email']); ?></td>
                            <td><?php   ?></td>
                            <td><?php  ?></td>
                            <td><a href="?edit=<?php echo $row['id']; ?>"><i class="far fa-edit green-text"></i></a></td>
                            <td class="right"><a href="?delid=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');"><i class="fas fa-trash red-text"></i></a></td>
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
