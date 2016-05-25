<?php

class User
{
    private $personalHandle;

    function __construct($handle)
    {
        $this->personalHandle = $handle;
    }

    public function register($name, $email, $password, $bDate)
    {
        try {
            $hashed = password_hash($password, PASSWORD_BCRYPT);

            $first = $name['first'];
            $last = $name['last'];

            $query = $this->personalHandle->prepare("INSERT INTO `users`(`fName`, `lName`, `email`, `password`, `birthDate`) VALUES(?, ?, ?, ?, ?)");
            $query->bindParam(1, $first);
            $query->bindParam(2, $last);
            $query->bindParam(3, $email);
            $query->bindParam(4, $hashed);
            $query->bindParam(5, $bDate);

            $query->execute();

            return $query;
        }

        catch(PDOException $e)
        {
            return -1;
        }
    }

    public function login($email, $password)
    {
        try
        {

             $query = $this->personalHandle->prepare("SELECT * FROM `users` WHERE email = :em LIMIT 1");
             $query->execute(array(':em' => $email));


             $result = $query->fetch(PDO::FETCH_ASSOC);

             if ($query->rowCount() > 0) {

                 if (password_verify($password, $result['password'])) {

                     // user is indeed, valid
                     $_SESSION['session_active'] = $result['id'] . RANDOM_S;
                     $_SESSION['user_id'] = $result['id'];
                     $_SESSION['fName'] = $result['fName'];
                     $_SESSION['lName'] = $result['lName'];
                     $_SESSION['email'] = $result['email'];
                     $_SESSION['bDate'] = $result['birthDate'];

                     return true;
                 }
             }

             return false;
         }

         catch(PDOException $e)
         {
             header('Location: index.php');
             exit;
         }
    }

    public function getUser($email)
    {
        try
        {
            if (!$this->isLoggedIn()) return null;
            else
            {
                $query = $this->personalHandle->prepare("SELECT * FROM `users` WHERE email = ?");
                $query->bindParam(1, $email);
                $query->execute();

                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($query->rowCount() > 0){

                    $data['fName'] = $result['fName'];
                    $data['lName'] = $result['lName'];
                    $data['email'] = $result['email'];
                    $data['bDate'] = $result['birthDate'];
                    $data['user_id'] = $result['id'];
                    return $data;
                }

                else return null;
            }
        }
            catch(PDOException $e)
        {
            header('Location: index.php');
            exit;
        }
    }

    public function getUserByID($id)
    {
        try
        {
            if (!$this->isLoggedIn()) return null;
            else
            {
                $query = $this->personalHandle->prepare("SELECT * FROM `users` WHERE id = ?");
                $query->bindParam(1, $id);
                $query->execute();

                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($query->rowCount() > 0){

                    $data['fName'] = $result['fName'];
                    $data['lName'] = $result['lName'];
                    $data['email'] = $result['email'];
                    $data['bDate'] = $result['birthDate'];
                    $data['user_id'] = $result['id'];
                    return $data;
                }

                else return null;
            }
        }
        catch(PDOException $e)
        {
            header('Location: index.php');
            exit;
        }
    }


    public function getUsersByName($name)
    {
        try {

            if (!$this->isLoggedIn()) return null;

            $n = explode(' ', $name);
            if(isset($n[0])) $n[0] = $n[0].'%';
            if(isset($n[1])) $n[1] = $n[1].'%';

            $query = $this->personalHandle->prepare("SELECT email, fName, lName FROM `users` WHERE fName LIKE ? OR lName LIKE ? OR fName LIKE ? OR lName LIKE ?");
            $query->bindParam(1, $n[0]);
            $query->bindParam(2, $n[1]);
            $query->bindParam(3, $n[1]);
            $query->bindParam(4, $n[0]);
            $query->execute();

            $result = $query->fetchAll();
            return $result;
        }

        catch (PDOException $e) {
            header('Location: index.php');
            exit;
        }
    }

    public function isLoggedIn()
    {
        if(isset($_SESSION['session_active']))
            return true;
        else return false;
    }

    public function isRelatedTo($remoteID)
    {
        try{

            if (!$this->isLoggedIn()) return null;

            $query = $this->personalHandle->prepare("SELECT * from relationships WHERE ( sender = ? AND receiver = ? ) OR ( sender = ? AND receiver = ?)");
            $query->bindParam(1, $_SESSION['user_id']);
            $query->bindParam(2, $remoteID);
            $query->bindParam(3, $remoteID);
            $query->bindParam(4, $_SESSION['user_id']);

            $query->execute();
            $result = $query->fetch();
            if($query->rowCount() > 0)
            {
                return $result['status'];
            }
            else return 0;
        }

        catch (PDOException $e) {
            header('Location: index.php');
            exit;
        }
    }

    public function isFriendOf($remoteID)
    {
        try{

            if (!$this->isLoggedIn()) return null;

            $query = $this->personalHandle->prepare("SELECT * from relationships WHERE (( sender = ? AND receiver = ? ) OR ( sender = ? AND receiver = ?)) AND status = 2");
            $query->bindParam(1, $_SESSION['user_id']);
            $query->bindParam(2, $remoteID);
            $query->bindParam(3, $remoteID);
            $query->bindParam(4, $_SESSION['user_id']);

            $query->execute();
            $result = $query->fetch();
            if($query->rowCount() > 0)
            {
                return true;
            }
            else return false;
        }

        catch (PDOException $e) {
            header('Location: index.php');
            exit;
        }
    }

    public function sendRequest($userID)
    {
        try {

            if (!$this->isLoggedIn()) return null;
            if($_SESSION['user_id'] == $userID) return null;


            $query = $this->personalHandle->prepare("INSERT INTO `relationships`(sender, receiver, status) VALUES(?, ?, 1)");
            $query->bindParam(1, $_SESSION['user_id']);
            $query->bindParam(2, $userID);
            $query->execute();

            return $query;
        }

        catch (PDOException $e) {
                    header('Location: index.php');
                    exit;
                }
    }

    public function getRequests()
    {
        try {

            if (!$this->isLoggedIn()) return null;


            $query = $this->personalHandle->prepare("SELECT * FROM `relationships` WHERE receiver = ? AND status = 1");
            $query->bindParam(1, $_SESSION['user_id']);
            $query->execute();
            $result = $query->fetchAll();
            if ($query->rowCount() > 0) {
                // requests pending.
                return $result;
            }
            else return null;
        }

        catch (PDOException $e) {
                    header('Location: index.php');
                    exit;
                }
    }

    public function getRequestHistory()
    {
        try {

            if (!$this->isLoggedIn()) return null;


            $query = $this->personalHandle->prepare("SELECT * FROM `relationships` WHERE sender = :me");
            $query->bindParam(':me', $_SESSION['user_id']);
            $query->execute();
            $r = $query->fetchAll();
            if ($query->rowCount() > 0) {
                return $r;
            }
            else return null;
        }

        catch (PDOException $e) {
            header('Location: index.php');
            exit;
        }
    }


    public function getFriends()
    {
        try {

            if (!$this->isLoggedIn()) return null;


            $query = $this->personalHandle->prepare("SELECT * FROM `relationships` WHERE (receiver = :me OR sender = :me) AND status = 2");
            $query->bindParam(':me', $_SESSION['user_id']);
            $query->execute();
            $result = $query->fetchAll();
            if ($query->rowCount() > 0) {
                // requests pending.
                return $result;
            }
            else return null;
        }

        catch (PDOException $e) {
            header('Location: index.php');
            exit;
        }
    }

    public function acceptFriend($user)
    {
        try {

            if (!$this->isLoggedIn()) return null;


            $query = $this->personalHandle->prepare("UPDATE `relationships` SET status = 2 WHERE sender = ? AND receiver = ?");
            $query->bindParam(1, $user);
            $query->bindParam(2, $_SESSION['user_id']);
            $query->execute();

            return $query;
        }

        catch (PDOException $e) {
            header('Location: index.php');
            exit;
        }
    }


    public function declineFriend($user)
    {
        try {

            if (!$this->isLoggedIn()) return null;


            $query = $this->personalHandle->prepare("DELETE FROM `relationships` WHERE sender = ? AND receiver = ?");
            $query->bindParam(1, $user);
            $query->bindParam(2, $_SESSION['user_id']);
            $query->execute();

            return $query;
        }

        catch (PDOException $e) {
            header('Location: index.php');
            exit;
        }
    }

    public function deleteFriend($user)
    {
        try {

            if (!$this->isLoggedIn()) return null;

            $q = $this->personalHandle->prepare('DELETE FROM `relationships` WHERE (sender = :me AND receiver = :them) OR (receiver = :me AND sender = :them)');

            $q->bindParam(':me', $_SESSION['user_id'], PDO::PARAM_INT);

            $q->bindParam(':them', $user , PDO::PARAM_INT);

            $q->execute();

            return $q;
        }

        catch (PDOException $e) {
            die($e->getMessage());
            header('Location: index.php');
            exit;
        }
    }


    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['session_active']);
        session_destroy();
    }
}