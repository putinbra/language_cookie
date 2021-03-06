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
$english = "en";

function getlanguageexist($language_path, $language){
    setcookie('languageCookie', $language, strtotime('+90 days'));
    require_once($language_path);
}

function getlanguage($language_path, $language, $error_language_not_exist){
    (file_exists($language_path)) ? getlanguageexist($language_path, $language) : require_once($error_language_not_exist);
}

function browserlanguage($browser_language_path, $lang){
    require_once($browser_language_path);
    setcookie('languageCookie', $lang, strtotime('+90 days'));
}

function defaultbrowserlanguage($deafult_language_path, $english){
    require_once($deafult_language_path);
    setcookie('languageCookie', $english, strtotime('+90 days'));
}

function browserlanguagepathexist($browser_language_path, $lang, $deafult_language_path, $english){
    (file_exists($browser_language_path)) ? browserlanguage($browser_language_path, $lang) : defaultbrowserlanguage($deafult_language_path, $english);
}

function cookienotissetget($browser_language_path, $lang, $deafult_language_path, $english){
    if(!isset($_GET['lang'])) browserlanguagepathexist($browser_language_path, $lang, $deafult_language_path, $english);  
}

if(isset($_GET['lang'])) getlanguage($language_path, $language, $error_language_not_exist);

(isset($_COOKIE['languageCookie'])) ? require_once($cookie_language_path): cookienotissetget($browser_language_path, $lang, $deafult_language_path, $english); 







