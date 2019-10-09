<?php
 require_once ('MysqliDb.php');

 $mysqli = new mysqli ('localhost', 'root', '', 'pos_inventory');
 $db = new MysqliDb ($mysqli);
?>