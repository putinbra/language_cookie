<?php

session_start();

$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$acceptLang = ['de', 'en']; 
$lang = in_array($lang, $acceptLang) ? $lang : 'en';
$browser_language_path = "{$lang}/index_{$lang}.php";
$language = $_GET['lang'] ?? "en";
$language_path = "{$language}/index_{$language}.php";
$deafult_language_path = "en/index_en.php";
$error_language_not_exist = "errors/error-lang-404.php";
$cookie_language_path = "{$_COOKIE['languageCookie']}/index_{$_COOKIE['languageCookie']}.php";
$language_cookie_name = 'languageCookie';
$cookie_strtotime = strtotime('+90 days');
$english = "en";

function getlanguageexist($language_path, $language, $language_cookie_name, $cookie_strtotime){
    require_once($language_path);
    setcookie($language_cookie_name, $language, $cookie_strtotime);
}

function getlanguage($language_path, $language, $language_cookie_name, $cookie_strtotime, $error_language_not_exist){
    (file_exists($language_path)) ? getlanguageexist($language_path, $language, $language_cookie_name, $language, $cookie_strtotime) : require_once($error_language_not_exist);
}

function browserlanguage($browser_language_path, $language_cookie_name, $lang, $cookie_strtotime){
    require_once($browser_language_path);
    setcookie($language_cookie_name, $lang, $cookie_strtotime);
}

function defaultbrowserlanguage($deafult_language_path, $language_cookie_name, $english, $cookie_strtotime){
    require_once($deafult_language_path);
    setcookie($language_cookie_name, $english, $cookie_strtotime);
}

function browserlanguagepathexist($browser_language_path, $language_cookie_name, $lang, $cookie_strtotime, $deafult_language_path, $english){
    (file_exists($browser_language_path)) ? browserlanguage($browser_language_path, $language_cookie_name, $lang, $cookie_strtotime) : defaultbrowserlanguage($deafult_language_path, $language_cookie_name, $english, $cookie_strtotime);
}

function cookienotissetget($browser_language_path, $language_cookie_name, $lang, $cookie_strtotime, $deafult_language_path, $english){
    if(!isset($_GET['lang'])) browserlanguagepathexist($browser_language_path, $language_cookie_name, $lang, $cookie_strtotime, $deafult_language_path, $english);  
}

if(isset($_GET['lang'])) getlanguage($language_path, $language, $language_cookie_name, $language, $cookie_strtotime, $error_language_not_exist);

(isset($_COOKIE['languageCookie'])) ? require_once($cookie_language_path): cookienotissetget($browser_language_path, $language_cookie_name, $lang, $cookie_strtotime, $deafult_language_path, $english); 