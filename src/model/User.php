<?php
class User {
    private $email;
    private $username;
    private $userId;
    private $password;

    public function __construct ($email, $username, $userId, $password) {
        $this->email = $email;
        $this->username = $username;
        $this->userId = $userId;
        $this->password = $password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getPassword() {
        return $this->password;
    }

    public function toArray() {
        return array(
            "id" => $this->userId,
            "username" => $this->username,
            "email" => $this->email,
            "password" => $this->password
        );
    }

    public static function isValidUsername($username, $db) {
        $u = pg_escape_string($username);
        $query = "SELECT username FROM users WHERE username = '$u'";
        $result = pg_query($db, $query);
        return !pg_fetch_assoc($result);
    }

    public static function isValidEmail($email) {
        $validFormat = filter_var( $email, FILTER_VALIDATE_EMAIL ) !== false;
        return $validFormat;
    }

    public static function isUniqueEmail($email, $db) {
        $e = pg_escape_string($email);
        $query = "SELECT email FROM users WHERE email = '$e'";
        $result = pg_query($db, $query);
        return !pg_fetch_assoc($result);
    }

    public static function isValidPassword($password) {
        return $password == $password;
    }


    //Returns a user object if the query was successful
    //returns null otherwise
    public static function getUserById($id, $db) {
        $id = pg_escape_string($id);
        $query = "SELECT * FROM users WHERE id='$id'";
        $result = pg_query($db, $query);
        $row = pg_fetch_assoc($result);
        if ($row) {
            return new User(
                $row["email"],
                $row["username"],
                $row["id"],
                $row["password"]
            );
        }
        return null;
    }

    //Returns a user object if the query was successfull
    //returns null otherwise
    public static function getUserByUsername($username, $db) {
      $username = pg_escape_string($username);
      $query = "SELECT * FROM users WHERE username = '$username'";
      $result = pg_query($db, $query);
      $row = pg_fetch_assoc($result);
      if ($row) {
        return new User(
          $row["email"],
          $row["username"],
          $row["id"],
          $row["password"]
        );
      }

      return null;
    }

    //Returns a boolean to indicate if the user was successfully deleted
    //will return true if the user doesn't exist
    public static function deleteUser($id, $db) {
        $id = pg_escape_string($id);

        if (!User::getUserById($id, $db)) {
            return true;
        }

        $query = "DELETE FROM users WHERE id = '$id'";
        pg_query($db, $query);

        return !User::getUserById($id, $db);
    }

    //Returns a new user object with the specified parameters if the query was successful
    //returns null otherwise
    public static function persist($email, $username, $password, $db) {

        $errorMessages = array();

        $isValidEmail = User::isValidEmail($email);

        if (!$isValidEmail) {
          array_push($errorMessages, "Invalid email");
        }

        $isUniqueEmail = User::isUniqueEmail($email, $db);

        if (!$isUniqueEmail) {
          array_push($errorMessages, "Email already exists");
        }

        $isValidUsername = User::isValidUsername($username, $db);

        if (!$isValidUsername) {
          array_push($errorMessages, "Username already exists");
        }

        $isValidPassword = User::isValidPassword($password);

        if (!$isValidPassword) {
          array_push($errorMessages, "Invalid password");
        }

        $isValidUser = $isValidEmail && $isUniqueEmail && $isValidUsername && $isValidPassword;

        if ($isValidUser) {
            $escapedEmail = pg_escape_string(filter_var( $email, FILTER_VALIDATE_EMAIL ));
            $escapedUsername = pg_escape_string($username);
            $escapedPassword = pg_escape_string($password);
            $escapedPassword = hash('sha256', $escapedPassword);
            $query = "INSERT INTO users (email, username, password) VALUES ('$escapedEmail', '$escapedUsername', '$escapedPassword') RETURNING id";
            $result = pg_query($db, $query);
            if ($row = pg_fetch_assoc($result)) {
                $id = $row["id"];
                if (intval(gettype($id)) > -1) {
                    return new User($email, $username, intval($id), $password);
                }
            } else {
                return null;
            }
        }

        return $errorMessages;
    }
}
