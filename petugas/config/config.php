<?php
if (!defined('CONFIG_INCLUDED')) {
    define('CONFIG_INCLUDED', true);

    function dbConnect() {
        $db = new mysqli("localhost", "root", "secretpassword", "db_pdintan"); // Adjust to your server settings.
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        return $db;
    }
}
?>
