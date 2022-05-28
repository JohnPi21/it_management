<?php

namespace Support\Input;

class Input
{
    public $pattern = null;
    public $required = false;
    public $err = null;
    public $value = null;
    public $name = null;

    function __construct()
    {
        global $validation_form;
        $validation_form = new Validation();
    }

    public function req($err = null)
    {
        $this->err = $err;
        $this->required = true;
        return $this;
    }

    public function check_req()
    {
        if ($this->required == true) {
            $this->required = false;
            return true;
        }

        return false;
    }
    public function html_code()
    {
        return html_entity_decode($this->value);
    }

    public function post($key, $validate = null, $default = null)
    {
        global $validation_form, $app;

        $reqired = $this->check_req();

        if (!isset($_POST[$key]) || empty(trim($_POST[$key]))) {
            if ($reqired) {
                $app->error(
                    $this->err ??=
                        ucfirst($key) . " input value is missing ( not set )"
                );
            }

            $this->value = $default;
            return $this;
        }

        if ($_POST[$key] == 'NECUNOSCUT') {
            $this->value = 'NECUNOSCUT';
            return $this;
        }

        if (is_array($_POST[$key])) {
            $this->value = $_POST[$key];
            return $this;
        }

        if ($validate === false || $validate === null) {
            $this->value = $_POST[$key];
            return $this;
        }

        if (is_array($validate) && !is_array($_POST[$key])) {
            $app->error(
                ucfirst($key) . " input value is invalid ( array problem )"
            );
        }

        if ($validate !== null) {
            $res = $validation_form
                ->name($key)
                ->value($_POST[$key])
                ->boolPattern($validate);

            if ($res === null) {
                $app->error(
                    ucfirst($key) .
                        " input value is invalid ( validation error )"
                );
            }
            $this->value = $res;
            return $this;
        }

        $value = trim($_POST[$key]);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);

        $this->value = $value;
        return $this;
    }

    public function get($key, $validate = null, $default = null)
    {
        global $validation_form, $app;

        $reqired = $this->check_req();

        if (!isset($_GET[$key]) || empty($_GET[$key])) {
            if ($reqired) {
                $app->error(
                    $this->err ??= ucfirst($key) . " input value is missing"
                );
            }
            $this->value = $default;
            return $this;
        }

        if (is_array($_GET[$key])) {
            $this->value = $_GET[$key];
            return $this;
        }

        //Modificare pentru a transforma id ul din '' in null

        // if(empty($_GET[$key])){
        //     $this->value = null;
        //     return $this;
        // }

        if (is_array($validate) && !is_array($_GET[$key])) {
            $app->error(ucfirst($key) . " input value is invalid");
        }

        if ($validate !== null) {
            $res = $validation_form
                ->name($key)
                ->value($_GET[$key])
                ->boolPattern($validate);
            if ($res == null) {
                $app->error(ucfirst($key) . " input value is invalid");
            }
            $this->value = $res;
            return $this;
        }

        $value = trim($_GET[$key]);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);

        $this->value = $value;
        return $this;
    }

    //Check database for a value
    public function searchDb($value, $column, $table, $null = false): bool
    {
        global $db;
        $db->where($column, $value);
        $res = $db->get($table);

        if (empty($res)) {
            return false;
        }
        return true;
    }
    //If the value doesn't exist in database, return an error
    public function mustExist($column, $table): self
    {
        global $app;
        if (!$this->searchDb($this->value, $column, $table)) {
            $app->error("Valoarea " . $this->value . " nu exista!");
        }
        return $this;
    }
    //If value exists in database, return an error
    public function mustNotExist($column, $table): self
    {
        global $app;
        if ($this->searchDb($this->value, $column, $table)) {
            $app->error("Valoarea " . $this->value . " exista deja!");
        }
        return $this;
    }

    public function min($length, $err, $int = false): self
    {
        global $app;

        if (!$int && strlen($this->value) < $length && !empty($this->value)) {
            $app->error($err);
        }

        if ($int && $this->value < intval($length) && !empty($this->value)) {
            $app->error($err);
        }

        return $this;
    }

    public function max($length, $err, $int = false): self
    {
        global $app;

        if (!$int && strlen($this->value) > $length && !empty($this->value)) {
            $app->error($err);
        }

        if ($int && $this->value > $length && !empty($this->value)) {
            $app->error($err);
        }

        return $this;
    }

    public function slugify($text = null)
    {
        $text ??= $this->value;
        // replace non letter or digits by -
        $text = preg_replace("~[^\pL\d]+~u", "-", $text);

        // transliterate
        $text = iconv("utf-8", "us-ascii//TRANSLIT", $text);

        // remove unwanted characters
        $text = preg_replace("~[^-\w]+~", "", $text);

        // trim
        $text = trim($text, "-");

        // remove duplicate -
        $text = preg_replace("~-+~", "-", $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return false;
        }

        return $text;
    }
}
