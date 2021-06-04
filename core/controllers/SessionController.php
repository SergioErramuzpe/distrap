<?php


class SessionController
{
    /**
     * @var null
     */
    private static $instance;
    private  $db;

    private function __construct ($db) {
        session_start();
        $this->db = $db;
    }

    public static function getInstance(DataBase $db)
    {
        if (is_null(self::$instance))
            self::$instance = new self($db);
        return self::$instance;
    }

    public function loginTry() {
        $data = $this->db->getLoged();
        if (($data == -1) || ($data == -2)) {
            if ($data == -1)
                return -1;
            return -2;
        } else {
            $data = $this->db->getLogedParams();
            $user = $data->fetch_assoc();
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['id'] = $user['id'];
            if ($user['isAdmin'] == 1)
                $_SESSION['isAdmin'] = 1;
            else
                $_SESSION['isAdmin'] = 0;
            $_SESSION['sessionUp'] = 1;
            return 0;
        }
    }

    public function getName() {
        return $_SESSION['name'];
    }

    public function getEmail() {
        return $_SESSION['email'];
    }

    public function getId() {
        return $_SESSION['id'];
    }

    public function isAdmin() {
        return $_SESSION['isAdmin'];
    }
    public function getSession() {
        if (!isset($_SESSION['sessionUp']))
            return 0;
        return $_SESSION['sessionUp'];
    }

    public function logout() {
        unset($_SESSION['isAdmin']);
        unset($_SESSION['sessionUp']);
        session_unset();
    }




}
