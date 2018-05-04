<?php

Class News
{
    public function Show($param = "")
    {
        global $con;

        $data = $con->prepare('SELECT * FROM news :param');
        $data->execute(array(
            ':param' => $param
        ));

        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function View($id)
    {
        global $con;

        $data = $con->prepare('SELECT * FROM news WHERE id = :id');
        $data->execute(array(
            ':id' => $id
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
            ':content'   => $content,
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
            ':content' => $content,
            ':id'      => $id
        ));

    }

    public function Delete($id)
    {
        global $con;

        $data = $con->prepare('DELETE FROM news WHERE id = :id');
        $data->execute(array(
            ':id' => $id
        ));
    }
}

Class User
{
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

    public function Verify()
    {

    }

    public function Authenticated()
    {
        if(isset($_SESSION['username']) && isset($_SESSION['password']))
        {
            return true;
        }

        return false;
    }

    public function Login()
    {

    }

    public function Register()
    {

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
            0 => 'green', // Green
            1 => 'orange', // Orange
            2 => 'red'  // Red
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
