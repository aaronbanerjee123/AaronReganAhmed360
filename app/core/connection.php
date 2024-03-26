<?php
if($_SERVER['SERVER_NAME'] == "localhost"){
    if(!defined('DBUSER')) define ("DBUSER","root");
    if(!defined('DBPASS')) define ("DBPASS","");

    if(!defined('DBNAME')) define ("DBNAME", "myblog_db");
    if(!defined('DBHOST')) define ("DBHOST", "localhost");
}else{
    if(!defined("DBUSER")) define ("DBUSER","root");
    if(!defined("DBPASS")) define ("DBPASS","");

    if(!defined('DBNAME')) define ("DBNAME", "myblog_db");
    if(!defined('DBHOST')) define ("DBHOST", "localhost");
}



