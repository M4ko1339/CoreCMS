<?php

include('header.php');

$news = new News();

$_SESSION['username'] = 'M4ko';

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
                <div class="content-header col s12">
                    New news post
                </div>

                <div class="content-box col s12">
                    <form method="POST">
                        <div class="input-field col s12">
                            <label>Title</label>
                            <input type="text" name="title" />
                        </div>

                        <div class="input-field col s12">
                            <label>Content</label>
                            <textarea class="materialize-textarea" name="content"></textarea>
                        </div>

                        <div class="input-field col s12">
                            <input type="submit" name="post" class="btn" value="Post" />
                        </div>
                    </form>
                </div>

                <?php if(isset($_POST['post'])): ?>
                    <?php if(!empty($_POST['title']) && !empty($_POST['content'])): ?>
                        <?php if(!$news->Duplicate($_POST['title'])): ?>
                            <?php $news->Create($_POST['title'], $_SESSION['username'], $_POST['content']); ?>
                            <div class="response col s12 green">
                                Successfully posted!
                            </div>
                        <?php else: ?>
                            <div class="response col s12 red">
                                Duplicate post was found!
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="response col s12 red">
                            Please fill in all fields!
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php elseif(isset($_GET['edit']) && $news->Exist((int)$_GET['edit'])): ?>

            <?php elseif(isset($_GET['delid']) && $news->Exist((int)$_GET['delid'])): ?>
                <?php
                    $news->Delete((int)$_GET['delid']);
                    header('Location: news.php');
                    exit;
                ?>
            <?php else: ?>
                <table class="responsive-table">
                    <th>Title</th>
                    <th>Author</th>
                    <th>Summary</th>
                    <th>Posted</th>
                    <th></th>
                    <th class="right"></th>

                    <?php foreach($news->Show() as $row): ?>
                        <tr>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo ucfirst($row['author']); ?></td>
                            <td><?php echo substr($row['content'], 0, 30); ?>..</td>
                            <td><?php echo date('j. F, Y', $row['post_date']); ?></td>
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
