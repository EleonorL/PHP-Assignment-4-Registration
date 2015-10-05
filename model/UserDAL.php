<?php

class UserDAL {

    public function checkUserFile($name) {
        if(file_exists(self::getFileName($name))) {
            return false;
        }
        else
            return true;
    }

    public function load($name) {
        if($this->checkUserFile($name)) {
            $fileContent = file_get_contents(self::getFileName($name));
            if($fileContent !== FALSE) {
                return unserialize($fileContent);
            }
        }
        return null;
    }

    public function save(User $u) {
        file_put_contents($u->getUsername(), serialize($u->getPassword()));
    }

    public function getFileName($name) {
        return Settings::DATAPATH . addslashes($name);
    }

}