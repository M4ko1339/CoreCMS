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

    public function Info($username)
    {
        global $con;

        $data = $con->prepare('SELECT * FROM users WHERE username = :username');
        $data->execute(array(
            ':username' => $username
        ));

        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function LastIP($username)
    {
        global $con;

        $data = $con->prepare('SELECT ip_address FROM logs WHERE data = :username AND log_date = ( SELECT MAX(log_date) FROM logs WHERE data = :username AND log_date < ( SELECT MAX(log_date) FROM logs WHERE data = :username))');
        $data->execute(array(
            ':username' => $username
        ));

        foreach($data->fetchAll(PDO::FETCH_ASSOC) as $row)
        {
            return $row['ip_address'];
        }
    }

    public function LastLogin($username)
    {
        global $con;

        $data = $con->prepare('SELECT log_date FROM logs WHERE data = :username AND log_date = ( SELECT MAX(log_date) FROM logs WHERE data = :username AND log_date < ( SELECT MAX(log_date) FROM logs WHERE data = :username))');
        $data->execute(array(
            ':username' => $username
        ));

        foreach($data->fetchAll(PDO::FETCH_ASSOC) as $row)
        {
            return $row['log_date'];
        }
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
            $data = $con->prepare('UPDATE users SET last_ip = :ip, last_login = :login WHERE username = :username');
            $data->execute(array(
                ':ip'       => $_SERVER['REMOTE_ADDR'],
                ':login'    => time(),
                ':username' => $username
            ));

            return true;
        }

        return false;
    }

    public function Register()
    {
        global $con;
    }

    public function ChangePassword($username, $oldpassword, $newpassword)
    {
        global $con;

        $data = $con->prepare('SELECT COUNT(*) FROM users WHERE username = :username AND password = :password');
        $data->execute(array(
            ':username' => $username,
            ':password' => $oldpassword
        ));

        if($data->fetchColumn() == 1)
        {
            $salt = uniqid();

            $data = $con->prepare('UPDATE users SET password = :password, salt = :salt WHERE username = :username');
            $data->execute(array(
                ':password' => sha1($newpassword . $salt),
                ':salt'     => $salt,
                ':username' => $username
            ));

            return true;
        }

        return false;
    }

    public function ChangeEmail($username, $email)
    {
        global $con;

        $data = $con->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
        $data->execute(array(
            ':email' => $email
        ));

        if($data->fetchColumn() == 0)
        {
            $data = $con->prepare('UPDATE users SET email = :email WHERE username = :username');
            $data->execute(array(
                ':email'    => $email,
                ':username' => $username
            ));

            return true;
        }

        return false;
    }

    public function Edit($id, $email, $permissions)
    {
        global $con;

        $data = $con->prepare('UPDATE users SET email = :email, permissions = :perms WHERE id = :id');
        $data->execute(array(
            ':email'   => $email,
            ':perms'   => $permissions,
            ':id'      => (int)$id
        ));
    }

    public function Delete($id)
    {
        global $con;

        $data = $con->prepare('DELETE FROM users WHERE id = :id');
        $data->execute(array(
            ':id' => (int)$id
        ));
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
    public function Access($username, $action)
    {
        global $con;

        $data = $con->prepare('SELECT permissions FROM users WHERE username = :username');
        $data->execute(array(
            ':username' => $username
        ));

        foreach($data->fetchAll(PDO::FETCH_ASSOC) as $row)
        {
            $perm = json_decode($row['permissions'], true);
        }

        if($perm[$action] == "1")
        {
            return true;
        }

        return false;
    }

    public function Fetch($value)
    {
        return json_encode($value);
    }

    public function Get($id)
    {
        global $con;

        $data = $con->prepare('SELECT permissions FROM users WHERE id = :id');
        $data->execute(array(
            ':id' => $id
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
    public function Show()
    {
        global $con;

        $data = $con->prepare('SELECT * FROM notifications ORDER BY id DESC');
        $data->execute();

        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function View($id)
    {
        global $con;

        $data = $con->prepare('SELECT * FROM notifications WHERE id = :id');
        $data->execute(array(
            ':id' => $id
        ));

        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Exist($id)
    {
        global $con;

        $data = $con->prepare('SELECT COUNT(*) FROM notifications WHERE id = :id');
        $data->execute(array(
            ':id' => (int)$id
        ));

        if($data->fetchColumn() == 1)
        {
            return true;
        }

        return false;
    }

    public function Create($type, $message)
    {
        global $con;

        $data = $con->prepare('INSERT INTO notifications (type, message, active) VALUES(:type, :message, :active)');
        $data->execute(array(
            ':type'    => $type,
            ':message' => $message,
            ':active'  => 1
        ));
    }

    public function Toggle($id)
    {
        global $con;

        $data = $con->prepare('SELECT * FROM notifications WHERE id = :id');
        $data->execute(array(
            ':id' => (int)$id
        ));

        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $row)
        {
            if($row['active'] == "1")
            {
                $data = $con->prepare('UPDATE notifications SET active = 0 WHERE id = :id');
                $data->execute(array(
                    ':id' => (int)$id
                ));
            }
            else
            {
                $data = $con->prepare('UPDATE notifications SET active = 1 WHERE id = :id');
                $data->execute(array(
                    ':id' => (int)$id
                ));
            }
        }
    }

    public function Edit($id, $type, $message)
    {
        global $con;

        $data = $con->prepare('UPDATE notifications SET type = :color, message = :message WHERE id = :id');
        $data->execute(array(
            ':color'   => $type,
            ':message' => $message,
            ':id'      => (int)$id
        ));
    }

    public function Delete($id)
    {
        global $con;

        $data = $con->prepare('DELETE FROM notifications WHERE id = :id');
        $data->execute(array(
            ':id' => (int)$id
        ));
    }

    public function Broadcast()
    {
        global $con;

        $data = $con->prepare('SELECT COUNT(*) FROM notifications WHERE active = 1');
        $data->execute();

        if($data->fetchColumn() == 1)
        {
            $data = $con->prepare('SELECT * FROM notifications WHERE active = 1');
            $data->execute();

            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }
}

Class Options
{
    var $options = array(
        // General
        'general' => array(
            'website_name' => 'CoreCMS',
            'website_url'  => 'http://corecms.com'
        ),

        // ReCaptcha
        'recaptcha' => array(
            'client' => '',
            'secret' => ''
        ),
    );

    public function Encode($options)
    {
        return json_encode($options);
    }

    public function Store($data)
    {
        global $con;

        $data = $con->prepare('UPDATE options SET data = :data');
        $data->execute(array(
            ':data' => $data
        ));
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
    public function Fetch($type)
    {
        global $con;

        if($type == 0)
        {
            $data = $con->prepare('SELECT * FROM logs ORDER BY log_date DESC');
            $data->execute();

            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            $data = $con->prepare('SELECT * FROM logs WHERE type = :type ORDER BY log_date DESC');
            $data->execute(array(
                ':type' => (int)$type
            ));

            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function Store($type, $string)
    {
        global $con;

        // 1 = ERROR - 2 = USER - 3 = ATTACK - 4 = ADMIN LOGIN - 5 = USER LOGIN

        $data = $con->prepare('INSERT INTO logs (type, data, ip_address, log_date) VALUES(:type, :data, :ip, :logdate)');
        $data->execute(array(
            ':type'    => $type,
            ':data'    => $string,
            ':ip'      => $_SERVER['REMOTE_ADDR'],
            ':logdate' => time()
        ));
    }
}

Class Transaction
{
    public function Show()
    {
        global $con;

        $data = $con->prepare('SELECT * FROM transactions');
        $data->execute();

        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function View($id)
    {
        global $con;

        $data = $con->prepare('SELECT * FROM transactions WHERE id = :id');
        $data->execute(array(
            ':id' => (int)$id
        ));

        return $data->fetchAll(PDO::FETCH_ASSOC);
    }
}

Class Pagination
{

}

Class Install
{

}

?>
