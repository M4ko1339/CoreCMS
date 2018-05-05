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
        </div>
    </div>
</div>

<?php

include('footer.php');

?>
