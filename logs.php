<?php

include('header.php');

if(!$perms->Access($_SESSION['username'], 'logs_view'))
{
    header('Location: index.php');
    exit;
}

$type = array(
    1 => 'ERROR',
    2 => 'USER',
    3 => 'ATTACK',
    4 => 'LOGIN'
);

?>

<div class="container">
    <div class="row">
        <div class="content col s12">
            <div class="top-menu">
                <a href="index.php" class="btn back-button"><i class="fas fa-chevron-left"></i></a>
            </div>
        </div>

        <div class="content col s12">
            <div class="sub-menu col s12">
                <a href="?type=1" <?php echo (!isset($_GET['type'])) || (int)$_GET['type'] == 1?"class=\"btn sub-menu-button current-nav\"":"class=\"btn sub-menu-button\""; ?>>Errors</a>
                <a href="?type=2" <?php echo (isset($_GET['type'])) && (int)$_GET['type'] == 2?"class=\"btn sub-menu-button current-nav\"":"class=\"btn sub-menu-button\""; ?>>Users</a>
                <a href="?type=3" <?php echo (isset($_GET['type'])) && (int)$_GET['type'] == 3?"class=\"btn sub-menu-button current-nav\"":"class=\"btn sub-menu-button\""; ?>>Attacks</a>
                <a href="?type=4" <?php echo (isset($_GET['type'])) && (int)$_GET['type'] == 4?"class=\"btn sub-menu-button current-nav\"":"class=\"btn sub-menu-button\""; ?>>Logins</a>
            </div>

            <?php if(isset($_GET['type']) && (int)$_GET['type'] == 2): ?>
                <table>
                    <th>Type</th>
                    <th>Data</th>
                    <th>IP Address</th>
                    <th>Log Date</th>

                    <?php foreach($log->Fetch(2) as $row): ?>
                        <tr>
                            <td><?php echo $type[$row['type']]; ?></td>
                            <td><?php echo $row['data']; ?></td>
                            <td><?php echo $row['ip_address']; ?></td>
                            <td><?php echo date('H:i - j. F, Y', $row['log_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php elseif(isset($_GET['type']) && (int)$_GET['type'] == 3): ?>
                <table>
                    <th>Type</th>
                    <th>Data</th>
                    <th>IP Address</th>
                    <th>Log Date</th>

                    <?php foreach($log->Fetch(3) as $row): ?>
                        <tr>
                            <td><?php echo $type[$row['type']]; ?></td>
                            <td><?php echo $row['data']; ?></td>
                            <td><?php echo $row['ip_address']; ?></td>
                            <td><?php echo date('H:i - j. F, Y', $row['log_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php elseif(isset($_GET['type']) && (int)$_GET['type'] == 4): ?>
                <table>
                    <th>Type</th>
                    <th>Data</th>
                    <th>IP Address</th>
                    <th>Log Date</th>

                    <?php foreach($log->Fetch(4) as $row): ?>
                        <tr>
                            <td><?php echo $type[$row['type']]; ?></td>
                            <td><?php echo $row['data']; ?></td>
                            <td><?php echo $row['ip_address']; ?></td>
                            <td><?php echo date('H:i - j. F, Y', $row['log_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <table>
                    <th>Type</th>
                    <th>Data</th>
                    <th>IP Address</th>
                    <th>Log Date</th>

                    <?php foreach($log->Fetch(1) as $row): ?>
                        <tr>
                            <td><?php echo $type[$row['type']]; ?></td>
                            <td><?php echo $row['data']; ?></td>
                            <td><?php echo $row['ip_address']; ?></td>
                            <td><?php echo date('H:i - j. F, Y', $row['log_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php

include('footer.php');

?>
