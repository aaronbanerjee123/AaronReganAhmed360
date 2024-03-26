<?php
if($_SERVER['SERVER_NAME'] == "localhost"){
    if(!defined('DBUSER')) define ("DBUSER","18186239");
    if(!defined('DBPASS')) define ("DBPASS","18186239");

    if(!defined('DBNAME')) define ("DBNAME", "db_18186239");
    if(!defined('DBHOST')) define ("DBHOST", "localhost");
}else{
    if(!defined("DBUSER")) define ("DBUSER","18186239");
    if(!defined("DBPASS")) define ("DBPASS","18186239");

    if(!defined('DBNAME')) define ("DBNAME", "db_18186239");
    if(!defined('DBHOST')) define ("DBHOST", "localhost");
}



