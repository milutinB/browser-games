<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
include_once('./src/model/User.php');

final class UserTest extends TestCase {

    public function testIsValidEmail() {

        $email = "example@email.com";
        $this->assertTrue(
            User::isValidEmail($email),
            $email . " should be a valid email"
        );

        $email = "obviously not an email address";
        $this->assertFalse(
            User::isValidEmail($email),
            "\'" .$email . "\' should not be a valid email"
        );
    }

    public function testIsUniqueEmail() {
        $db = pg_connect(getenv("DATABASE_URL"));
        $email = "alreadyexists@email.com";

        //Delete users with the test email
        $query = "DELETE FROM users WHERE email = 'alreadyexists@email.com'";
        pg_query($db, $query);

        //Test the test email is unique
        $this->assertTrue(
            User::isUniqueEmail($email, $db),
            'Users with this email address were just deleted so it should be unique'
        );

        //create a user with the test email
        $query = "INSERT INTO users (email) VALUES ('alreadyexists@email.com')";
        pg_query($db, $query);

        //Check the test email is now not unique
        $this->assertFalse(
            User::isUniqueEmail($email, $db),
            'A user with this email was just created so it is not unique'
        );

        //delete the test email
        $query = "DELETE FROM users WHERE email = 'alreadyexists@email.com'";
        pg_query($db, $query);

    }

    public function testIsValidUsername() {
        //test that a non existing username is valid
        $db = pg_connect(getenv("DATABASE_URL"));

        $query = "DELETE FROM users WHERE username = 'superoriginalusernamenoonehasthoughtof'";
        pg_query($db, $query);

        $username = "superoriginalusernamenoonehasthoughtof";
        $this->assertTrue(
            User::isValidUsername($username, $db)
        );

        //test that an existing username is not valid
        $query = "INSERT INTO users (email, username, password)
        VALUES ('superoriginal@email.com', 'superoriginalusernamenoonehasthoughtof', 'highlysecurepasssword')";
        pg_query($db, $query);
        $this->assertFalse(
            User::isValidUsername($username, $db),
            "The username exists, so it is not a valid new username"
        );

        $query = "DELETE FROM users WHERE username = 'superoriginalusernamenoonehasthoughtof'";
        pg_query($db, $query);
    }

    public function testPersist() {

        $db = pg_connect(getenv("DATABASE_URL"));

        $email = "test@email.com";
        $username = "testusername";
        $password = "testpassword";

        $query = "DELETE FROM users WHERE email = '$email' AND username = '$username'";
        pg_query($query);

        $user = User::persist($email, $username, $password, $db);

        $this->assertTrue(
            $user instanceof User
        );


        //Testing error messages

        $email = "not a valid email";
        $username = "username";
        $password = "testpassword";

        $errorMessages = User::persist($email, $username, $password, $db);
        $this->assertEquals(
          "Invalid email",
          $errorMessages[0]
        );

        $errorMessages = User::persist('test@email.com', 'testusername', 'testpassword', $db);

        $this->assertEquals(
          "Email already exists",
          $errorMessages[0]
        );

        $this->assertEquals(
          "Username already exists",
          $errorMessages[1]
        );

        $query = "DELETE FROM users WHERE email = 'test@email.com' AND username = 'testusername'";
        pg_query($query);
    }


    public function testGetUserByUsername() {
      $db = pg_connect(getenv("DATABASE_URL"));

      $username = "testuser";
      $email = "testemail";
      $password = "testpassword";

      $query = "DELETE FROM users WHERE username = 'testuser'";
      pg_query($db, $query);
      //test that function returns null when the user does not exists

      $result = User::getUserByUsername($username, $db);
      $this->assertNull(
        $result
      );

      $query = "INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$password')";
      $result = pg_query($db, $query);

      //test that the function returns a user bject when the query is successfull
      $user = User::getUserByUsername($username, $db);
      $this->assertTrue(
        $user instanceof User
      );

      $query = "DELETE FROM users WHERE username = 'testuser'";
      pg_query($db, $query);
    }

    public function testGetUserById() {
        $db = pg_connect(getenv("DATABASE_URL"));

        //Delete test user if it exists

        $query = "DELETE FROM users WHERE username = 'testuser'";
        pg_query($db, $query);

        $id = User::persist('testemail@email.com', 'testuser', 'securepassword', $db)
            ->getUserId();

        $user = User::getUserById($id, $db);

        $this->assertEquals(
            'testuser',
            $user->getUsername()
        );

        $this->assertEquals(
          'testemail@email.com',
           $user->getEmail()
        );

        $query = "DELETE FROM users WHERE username = 'testuser'";
        pg_query($db, $query);

        $user =  User::getUserById($id, $db);

        //The usr was just deleted so there should be no user with this id

        $this->assertNull(
            $user,
            "The query should return null"
        );

    }

    public function testDeleteUser() {

        $db = pg_connect(getenv("DATABASE_URL"));
        $query = "DELETE FROM users WHERE username='testuser'";
        pg_query($db, $query);

        $query = "INSERT INTO users (email, username, password)
        VALUES ('testemail@email.com', 'testuser', 'securepassword')
        RETURNING id";
        $result = pg_query($db, $query);
        $id = pg_fetch_assoc($result)["id"];

        $this->assertTrue(
            User::deleteUser($id, $db),
            "method call should delete user"
        );
    }
}
