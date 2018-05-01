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

        <div class="content col s12 m6">
            <div class="content-header col s12">
                Custom Box
            </div>

            <div class="content-box col s12">
                <div class="input-field col s12">
                    <label>Text Input</label>
                    <input type="text" />
                </div>

                <div class="input-field col s12">
                    <label>Password Input</label>
                    <input type="password" />
                </div>

                <div class="input-field col s12">
                    <input type="submit" class="btn" value="Button" />
                </div>
            </div>
        </div>

        <div class="content col s12 m6">
            <table class="responsive-table">
                <th>Name</th>
                <th>Age</th>
                <th>Country</th>

                <tr>
                    <td>John</td>
                    <td>42</td>
                    <td>USA</td>
                </tr>

                <tr>
                    <td>Ola</td>
                    <td>24</td>
                    <td>Norway</td>
                </tr>

                <tr>
                    <td>Justin</td>
                    <td>24</td>
                    <td>Netherlands</td>
                </tr>
            </table>
        </div>

        <div class="content col s12 m6">
            <div class="content-header col s12">
                Custom Box
            </div>

            <div class="content-box col s12">
                <form>
                    <p>
                        <label>
                            <input type="checkbox" class="filled-in" checked="checked" />
                            <span>Permission #1</span>
                        </label>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

include('footer.php');

?>
