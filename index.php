<?php

include('header.php');

?>

<div class="container">
    <div class="row">
        <div class="content col s12">
            <div class="top-menu">
                <a href="#" class="btn">New Notification</a>
            </div>
        </div>

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
                        <td>Green</td>
                        <td>Important message to the staff!</td>
                        <td class="green-text">Active</td>
                        <td><a href="#"><i class="fas fa-toggle-on orange-text"></i></a></td>
                        <td><a href="?edit=<?php echo $row['id']; ?>"><i class="far fa-edit green-text"></i></a></td>
                        <td class="right"><a href="?delid=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');"><i class="fas fa-trash red-text"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="content col s12 m3">
            <div class="content-box col s12">
                <div class="info-box">
                    <label>Username</label>
                    <div class="info-box-text">
                        Admin
                    </div>
                </div>

                <div class="info-box">
                    <label>Email</label>
                    <div class="info-box-text">
                        admin@corecms.com
                    </div>
                </div>

                <div class="info-box">
                    <label>Last IP</label>
                    <div class="info-box-text">
                        127.0.0.1
                    </div>
                </div>

                <div class="info-box">
                    <label>Last Login</label>
                    <div class="info-box-text">
                        10:20 - 11.05.2018
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include('footer.php');

?>
