<?php

include('header.php');

?>

<div class="container">
    <div class="row">
        <div class="content col s12">
            <div class="top-menu">
                <a href="#" class="btn">New Post</a>
            </div>
        </div>

        <div class="content col s12">
            <table class="responsive-table">
                <th>Title</th>
                <th>Author</th>
                <th>Summary</th>
                <th></th>
                <th class="right"></th>

                <tr>
                    <td>First post</td>
                    <td>M4ko</td>
                    <td>lorem ipsum salam dala loco..</td>
                    <td><a href="#"><i class="far fa-edit green-text"></i></a></td>
                    <td class="right"><a href="#"><i class="fas fa-trash red-text"></i></a></td>
                </tr>
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
