<?php

class Auth
{
  private $db;
  public $username;
  public $email;
  public $id;
  public $loggedIn;

  public function __construct($dbhandler)
  {
    $this->db = $dbhandler;
  }

  public function login($username, $password)
  {
    $query = $this->db->prepare('SELECT * FROM users WHERE email = ?');
    $execute = $query->execute([$username]);
    if ($execute) {
      if ($query->rowCount() > 0) {
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['password'])) {
          $_SESSION['username'] = $this->username = $user['username'];
          $_SESSION['email'] = $this->email = $user['email'];
          $_SESSION['id'] = $this->id = $user['id'];
          $_SESSION['loggedIn'] = $this->loggedIn = true;
          return true;
        }
        return false;
      }
      return false;
    }
    return false;
  }
}
