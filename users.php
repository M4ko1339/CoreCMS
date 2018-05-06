<?php

include('header.php');

$user  = new User();
$perms = new Permissions();

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
                                        <input type="checkbox" class="filled-in" checked="checked" />
                                        <span>Login Access</span>
                                    </label>
                                </p>
                            </fieldset>

                            <fieldset>
                                <legend>News Permissions</legend>
                                <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" checked="checked" />
                                        <span>View News</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" checked="checked" />
                                        <span>Post News</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" checked="checked" />
                                        <span>Edit News</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" checked="checked" />
                                        <span>Delete News</span>
                                    </label>
                                </p>
                            </fieldset>

                            <fieldset>
                                <legend>Users Permissions</legend>
                                <p>
                                    <label>
                                        <input type="checkbox" class="filled-in" checked="checked" />
                                        <span>View Users</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" checked="checked" />
                                        <span>Create Users</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" checked="checked" />
                                        <span>Edit Users</span>
                                    </label>

                                    <label>
                                        <input type="checkbox" class="filled-in" checked="checked" />
                                        <span>Delete Users</span>
                                    </label>
                                </p>
                            </fieldset>
                        </div>

                        <div class="input-field col s12">
                            <input type="submit" name="edit" class="btn" value="Confirm" />
                        </div>
                    </form>
                </div>
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
