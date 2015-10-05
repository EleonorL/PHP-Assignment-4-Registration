<?php

require_once("model/User.php");


class RegistrationView {

    private static $registration = "RegisterView::Register";
    private static $message = "RegisterView::Message";
    private static $name = "RegisterView::UserName";
    private static $password = "RegisterView::Password";
    private static $passRepeat = "RegisterView::PasswordRepeat";
    private static $regLink = "register";

    private $regSuccess = false;
    private $regFail = false;

    private function generateRegistrationForm($message){
        return '<h2>Register new user</h2>
                <form action="?register" method="post" enctype="multipart/form-data">
                    <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                        <p id="'.self::$message.'">'.$message.'</p>
                        <label for="'.self::$name.'">Username :</label>
                        <input type="text" size="20" name="'.self::$name.'" id="'.self::$name.'" value="'.$this->getUserName().'">
                        <br>
                        <label for="'.self::$password.'">Password  :</label>
                        <input type="password" size="20" name="'.self::$password.'" id="'.self::$password.'" value="">
                        <br>
                        <label for="'.self::$passRepeat.'">Repeat password  :</label>
                        <input type="password" size="20" name="'.self::$passRepeat.'" id="'.self::$passRepeat.'" value="">
                        <br>
                        <input id="submit" type="submit" name="'.self::$registration.'" value="Register">
                        <br>
                    </fieldset>
                </form>';
    }

    public function response() {
        return $this->doRegistrationForm();
    }

    private function doRegistrationForm() {
        $message = "";
        if($this->userWantsToRegister()) {
            if(!self::checkUsername())
                $message .= "Username has too few characters, at least 3 characters.";
            if ($this->getPassword() !== $this->getPassRepeat())
                $message .= "Passwords do not match.";
            if(!self::checkPassword())
                $message .= "Password has too few characters, at least 6 characters.";

            if($this->regFail)
                $message = "User exists, pick another username";
        }
        return $this->generateRegistrationForm($message);
    }

    public function userWantsToRegister() {
        return isset($_POST[self::$registration]);
    }

    public function clickedRegister() {
        return isset($_GET[self::$regLink]);
    }

    public function getRegLink() {
        return '<a href="?' . self::$regLink . '">Register a new user</a>';
    }

    public function getLoginLink() {
        return '<a href="?">Back to login</a>';
    }

    public function checkForm() {
        return (!self::checkUsername() && !self::checkPassword() && !self::comparePasswords());
    }

    public function setRegFail() {
        $this->regFail = true;
    }

    public function setRegSuccess() {
        $this->regSuccess = true;
    }


    private function getUsername() {
        if(isset($_POST[self::$name])) {
            return trim($_POST[self::$name]);
        }
        return "";
    }

    private function getPassword() {
        if(isset($_POST[self::$password])) {
            return trim($_POST[self::$password]);
        }
        return "";
    }

    private function getPassRepeat() {
        if(isset($_POST[self::$passRepeat])) {
            return trim($_POST[self::$passRepeat]);
        }
        return "";
    }

    public function getUser() {
        return new User($this->getUsername(), $this->getPassword());
    }

    private function checkUsername() {
        if(strlen($this->getUsername() < 3))
            return false;
        return true;
    }

    private function checkPassword() {
        if(strlen($this->getPassword() < 6))
            return false;
        return true;
    }

    private function comparePasswords() {
        if(strlen($this->getPassword()) !== strlen($this->getPassRepeat()))
            return false;
        return true;
    }

}