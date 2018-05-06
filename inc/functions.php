<?php

Class News
{
    public function Show()
    {
        global $con;

        $data = $con->prepare('SELECT * FROM news ORDER BY id DESC');
        $data->execute();

        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function View($id)
    {
        global $con;

        $data = $con->prepare('SELECT * FROM news WHERE id = :id');
        $data->execute(array(
            ':id' => (int)$id
        ));

        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Create($title, $author, $content)
    {
        global $con;

        $data = $con->prepare('INSERT INTO news (title, author, content, post_date)
        VALUES(:title, :author, :content, :post_date)');
        $data->execute(array(
            ':title'     => $title,
            ':author'    => $author,
            ':content'   => nl2br($content),
            ':post_date' => time()
        ));
    }

    public function Edit($id, $title, $author, $content)
    {
        global $con;

        $data = $con->prepare('UPDATE news SET title = :title, author = :author, content = :content WHERE id = :id');
        $data->execute(array(
            ':title'   => $title,
            ':author'  => $author,
            ':content' => nl2br($content),
            ':id'      => (int)$id
        ));

    }

    public function Delete($id)
    {
        global $con;

        $data = $con->prepare('DELETE FROM news WHERE id = :id');
        $data->execute(array(
            ':id' => (int)$id
        ));
    }

    public function Exist($id)
    {
        global $con;

        $data = $con->prepare('SELECT COUNT(*) FROM news WHERE id = :id');
        $data->execute(array(
            ':id' => (int)$id
        ));

        if($data->fetchColumn() == 1)
        {
            return true;
        }

        return false;
    }

    public function Duplicate($title)
    {
        global $con;

        $data = $con->prepare('SELECT COUNT(*) FROM news WHERE title = :title');
        $data->execute(array(
            ':title' => $title
        ));

        if($data->fetchColumn() > 0)
        {
            return true;
        }

        return false;
    }
}

Class User
{
    public function Show()
    {
        global $con;

        $data = $con->prepare('SELECT * FROM users ORDER BY id DESC');
        $data->execute();

        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function View($id)
    {
        global $con;

        $data = $con->prepare('SELECT * FROM users WHERE id = :id');
        $data->execute(array(
            ':id' => $id
        ));

        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Exist($id)
    {
        global $con;

        $data = $con->prepare('SELECT COUNT(*) FROM users WHERE id = :id');
        $data->execute(array(
            ':id' => (int)$id
        ));

        if($data->fetchColumn() == 1)
        {
            return true;
        }

        return false;
    }

    public function Create($username, $password, $email, $perms)
    {
        global $con;

        $salt = uniqid();

        $data = $con->prepare('INSERT INTO users (username, password, salt, permissions, email, register_ip, last_ip, register_date, last_login)
        VALUES(:username, :password, :salt, :permissions, :email, :register_ip, :last_ip, :register_date, :last_login)');
        $data->execute(array(
            ':username'      => $username,
            ':password'      => sha1($password . $salt),
            ':salt'          => $salt,
            ':permissions'   => $perms,
            ':email'         => $email,
            ':register_ip'   => $_SERVER['REMOTE_ADDR'],
            ':last_ip'       => 0,
            ':register_date' => time(),
            ':last_login'    => 0
        ));
    }

    public function Duplicate($username, $email)
    {
        global $con;

        $data = $con->prepare('SELECT COUNT(*) FROM users WHERE username = :username OR email = :email');
        $data->execute(array(
            ':username' => $username,
            ':email'    => $email
        ));

        if($data->fetchColumn() > 0)
        {
            return true;
        }

        return false;
    }

    public function Authenticated()
    {
        if(isset($_SESSION['username']) && isset($_SESSION['password']))
        {
            function Verify($username, $password)
            {
                global $con;

                $data = $con->prepare('SELECT COUNT(*) FROM users WHERE username = :username AND password = :password');
                $data->execute(array(
                    ':username' => $username,
                    ':password' => $password
                ));

                if($data->fetchColumn() == 1)
                {
                    return true;
                }

                return false;
            }

            if(Verify($_SESSION['username'], $_SESSION['password']))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        return false;
    }

    public function Salt($username)
    {
        global $con;

        $data = $con->prepare('SELECT salt FROM users WHERE username = :username');
        $data->execute(array(
            ':username' => $username
        ));

        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $row)
        {
            return $row['salt'];
        }
    }

    public function Login($username, $password)
    {
        global $con;

        $data = $con->prepare('SELECT COUNT(*) FROM users WHERE username = :username AND password = :password');
        $data->execute(array(
            ':username' => $username,
            ':password' => sha1($password)
        ));

        if($data->fetchColumn() == 1)
        {
            return true;
        }

        return false;
    }

    public function Register()
    {

    }

    public function Logout()
    {
        if(isset($_SESSION['username']) && isset($_SESSION['password']))
        {
            session_destroy();
            header('Location: login.php');
            exit;
        }
    }
}

Class Permissions
{
    public function Regular()
    {
        return json_encode(array(
            // General AdminCP
            'login'       => 0,

            // News System
            'news_post'   => 0,
            'news_edit'   => 0,
            'news_delete' => 0,

            // User System
            'user_create' => 0,
            'user_reset'  => 0,
            'user_edit'   => 0,
            'user_ban'    => 0,
            'user_delete' => 0,
        ));
    }

    public function Moderator()
    {
        return json_encode(array(
            // General AdminCP
            'login'       => 1,

            // News System
            'news_post'   => 1,
            'news_edit'   => 1,
            'news_delete' => 1,

            // User System
            'user_create' => 0,
            'user_reset'  => 1,
            'user_edit'   => 0,
            'user_ban'    => 1,
            'user_delete' => 0,
        ));
    }

    public function Administrator()
    {
        return json_encode(array(
            // General AdminCP
            'login'       => 1,

            // News System
            'news_post'   => 1,
            'news_edit'   => 1,
            'news_delete' => 1,

            // User System
            'user_create' => 1,
            'user_reset'  => 1,
            'user_edit'   => 1,
            'user_ban'    => 1,
            'user_delete' => 1,
        ));
    }

    public function Get($username)
    {
        global $con;

        $data = $con->prepare('SELECT permissions FROM users WHERE username = :username');
        $data->execute(array(
            ':username' => $username
        ));

        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $row)
        {
            return json_decode($row['permissions'], true);
        }
    }
}

Class Notification
{
    public function Create($type, $message)
    {
        global $con;

        $colors = array(
            0 => 'green',  // Green
            1 => 'orange', // Orange
            2 => 'red'     // Red
        );

        $data = $con->prepare('UPDATE notfications SET type = :type, message = :message, active = 1 WHERE id = 1');
        $data->execute(array(
            ':type'    => $colors[$type],
            ':message' => $message
        ));
    }

    public function Toggle()
    {
        global $con;

        $data = $con->prepare('SELECT * FROM notifications WHERE id = 1');
        $data->execute();

        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $row)
        {
            if($row['active'] == 1)
            {
                $data = $con->prepare('UPDATE notifications SET active = 0 WHERE id = 1');
                $data->execute();
            }
            else
            {
                $data = $con->prepare('UPDATE notifications SET active = 1 WHERE id = 1');
                $data->execute();
            }
        }
    }

    public function Broadcast()
    {
        global $con;

        $data = $con->prepare('SELECT COUNT(*) FROM notifications WHERE id = 1 AND active = 1');
        $data->execute();

        if($data->fetchColumn() == 1)
        {
            $data = $con->prepare('SELECT * FROM notifications WHERE id = 1 AND active = 1');
            $data->execute();

            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }
}

Class Sanitize
{
    public function Username($input)
    {

    }

    public function Email($input)
    {

    }

    public function Password($input)
    {

    }

    public function Text($input)
    {

    }
}

Class Logging
{
    public function Error()
    {
        global $con;

        $data = $con->prepare('INSERT INTO error_logs (error_type, error_message, error_time) VALUES(:type, :error_msg, :error_time)');
        $data->execute(array(
            ':type'        => $type,
            ':error_msg'   => $error,
            ':error_ time' => time()
        ));
    }
}

?>
