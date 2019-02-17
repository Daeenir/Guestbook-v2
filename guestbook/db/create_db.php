<?php
/**
 * Created by PhpStorm.
 * User: emilh
 * Date: 2019-02-17
 * Time: 13:02
 */
// DB settings
$host = 'localhost';
$login = 'login';
$passwd = 'password';
$db = 'database';

$link = mysqli_connect($host, $login, $passwd, $db);

$query = "CREATE TABLE IF NOT EXISTS `gb_posts` ( `PostId` INT(11) NOT NULL AUTO_INCREMENT , `Header` TEXT NOT NULL , `Name` TEXT NOT NULL , `Date` DATETIME NOT NULL , `Post` TEXT NOT NULL , PRIMARY KEY (`PostId`)) ENGINE = InnoDB;";

mysqli_query($link, $query);