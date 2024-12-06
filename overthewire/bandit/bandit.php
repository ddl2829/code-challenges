<?php

use phpseclib3\Net\SSH2;

require_once "../../vendor/autoload.php";


class Bandit {
    private SSH2 $ssh;
    private $currentLevel = 0;
    private $currentPassword = "bandit0";
    private $loadedCheckpoint = false;

    function __construct() {
        $this->ssh = new SSH2("bandit.labs.overthewire.org", 2220);
        if(file_exists('.checkpoint')) {
            $contents = explode(":", trim(file_get_contents('.checkpoint')));
            $this->currentLevel = $contents[0];
            $this->currentPassword = $contents[1];
            if($this->currentLevel > 0) {
                $this->loadedCheckpoint = true;
            }
        }
    }

    function reset() {
        $this->currentLevel = 0;
        $this->currentPassword = "bandit0";
    }

    function login() {
        return $this->ssh->login("bandit" . $this->currentLevel, $this->currentPassword);
    }

    function checkpoint() {
        file_put_contents(".checkpoint", $this->currentLevel . ":" . $this->currentPassword);
    }

    function play() {
        if(!$this->login()) {
            echo "Login failed for bandit" . $this->currentLevel . PHP_EOL;
            if($this->loadedCheckpoint) {
                $this->reset();
                if(!$this->login()) {
                    exit("Login failed for bandit0");
                }
            } else {
                exit();
            }
        }

        $this->checkpoint(); // password was good, save checkpoint

        if(method_exists($this, "bandit" . $this->currentLevel)) {
            echo "trying bandit" . $this->currentLevel . PHP_EOL;
            $this->currentPassword = $this->{"bandit" . $this->currentLevel}();
            if(!$this->currentPassword) {
                exit("No password found for bandit" . $this->currentLevel);
            }
            echo "bandit" . ($this->currentLevel + 1) . " password: " . $this->currentPassword . PHP_EOL;
        } else {
            exit("No method for bandit" . $this->currentLevel);
        }
        $this->ssh->disconnect();

        $this->currentLevel++;
        $this->play();
    }

    function bandit0() {
        $readmeContents = $this->ssh->exec("cat ~/readme");
        preg_match("/The password you are looking for is: (.*)/", $readmeContents, $matches);
        return $matches[1];
    }

    function bandit1() {
        return trim($this->ssh->exec("cat ~/-"));
    }

    function bandit2() {
        return trim($this->ssh->exec("cat ~/spaces\ in\ this\ filename"));
    }

    function bandit3() {
        $dirContents = trim($this->ssh->exec("ls -a inhere"));
        $names = explode("\n", $dirContents);
        $filename = $names[count($names) - 1];
        return trim($this->ssh->exec("cat inhere/$filename"));
    }

    function bandit4() {
        $dirContents = trim($this->ssh->exec("ls -a inhere"));
        $names = explode("\n", $dirContents);
        $filenames = array_diff($names, ['..', '.']);
        foreach($filenames as $filename) {
            $fileContents = trim($this->ssh->exec("cat inhere/$filename"));
            if(preg_match('/^[a-zA-Z0-9]+$/', $fileContents)) {
                return $fileContents;
            }
        }
        return null;
    }

    function bandit5() {
        return null;
    }
}


$b = new Bandit();
$b->play();