<?php

include('header.php');

$news = new News();

?>

<div class="container">
    <div class="row">
        <div class="content col s12">
            <div class="top-menu">
                <a href="?action=newpost" class="btn">New Post</a>
            </div>
        </div>

        <div class="content col s12">
            <?php if(isset($_GET['action']) && $_GET['action'] == "newpost"): ?>
                
            <?php elseif(isset($_GET['edit']) && $news->Exist((int)$_GET['edit'])): ?>

            <?php else: ?>
                <table class="responsive-table">
                    <th>Title</th>
                    <th>Author</th>
                    <th>Summary</th>
                    <th></th>
                    <th class="right"></th>

                    <?php foreach($news->Show() as $row): ?>
                        <tr>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo ucfirst($row['author']); ?></td>
                            <td><?php echo substr($row['content'], 0, 30); ?>..</td>
                            <td><a href="?edit=<?php echo $row['id']; ?>"><i class="far fa-edit green-text"></i></a></td>
                            <td class="right"><a href="?delid=<?php echo $row['id']; ?>"><i class="fas fa-trash red-text"></i></a></td>
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
