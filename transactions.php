<?php

include('header.php');

$tx = new Transaction();

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
                <a href="?type=1" <?php echo (!isset($_GET['type'])) || (int)$_GET['type'] == 1?"class=\"btn sub-menu-button current-nav\"":"class=\"btn sub-menu-button\""; ?>>Transactions</a>
                <a href="?type=2" <?php echo (isset($_GET['type'])) && (int)$_GET['type'] == 2?"class=\"btn sub-menu-button current-nav\"":"class=\"btn sub-menu-button\""; ?>>Shop Purchases</a>
            </div>

            <?php if(!isset($_GET['type']) || (int)$_GET['type'] == 1): ?>
                <table>
                    <th>Order ID</th>
                    <th>Token</th>
                    <th>Username</th>
                    <th>Payment ID</th>
                    <th>Payer ID</th>
                    <th>Amount</th>
                    <th>Order Date</th>

                    <?php foreach($tx->Show() as $row): ?>
                        <tr>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo $row['token']; ?></td>
                            <td class="yellow-text"><?php echo $row['username']; ?></td>
                            <td><?php echo $row['payment_id']; ?></td>
                            <td><?php echo $row['payer_id']; ?></td>
                            <td class="green-text"><?php echo CURRENCY_SIGN; ?> <?php echo $row['amount']; ?></td>
                            <td><?php echo date('H:i - j. F, Y', $row['order_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php elseif(isset($_GET['type']) && (int)$_GET['type'] == 2): ?>
                <table>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            <?php else: ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php

include('footer.php');

?>
