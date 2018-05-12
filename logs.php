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
            <table>
                <th>Type</th>
                <th>Data</th>
                <th>IP Address</th>
                <th>Log Date</th>

                <?php foreach($log->Fetch(0) as $row): ?>
                    <tr>
                        <td><?php echo $type[$row['type']]; ?></td>
                        <td><?php echo $row['data']; ?></td>
                        <td><?php echo $row['ip_address']; ?></td>
                        <td><?php echo date('H:i - j. F, Y', $row['log_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<?php

include('footer.php');

?>
