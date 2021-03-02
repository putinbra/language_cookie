<?php
session_start();

$language = $_GET['lang'] ?? "en";
$languagepage = "$language/index_$language.php";
$error_language_not_exist = "errors/error-lang-404.php";
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$acceptLang = ['de','en']; 
$browser_language = in_array($lang, $acceptLang) ? $lang : 'en';  
$brlang_path = "$browser_language/index_$browser_language.php";
$default_language = "en/index_en.php";

function cookie1($browser_language, $language, $default_language){
    setcookie('languageCookie[defaultLanguage]' , $default_language, strtotime('+90 days'));
    setcookie('languageCookie[browserLanguage]' , $browser_language, time() - 7776100);
    setcookie('languageCookie[language]' , $language, time() - 7776100);
}
function cookie2($browser_language, $default_language, $language){
    setcookie('languageCookie[language]' , $language, strtotime('+90 days'));
    setcookie('languageCookie[browserLanguage]' , $browser_language, time() - 7776100);
    setcookie('languageCookie[defaultLanguage]' , $default_language, time() - 7776100);
}
function cookie3($default_language, $language, $browser_language){
    setcookie('languageCookie[browserLanguage]' , $$browser_language, strtotime('+90 days'));
    setcookie('languageCookie[language]' , $language, time() - 7776100);
    setcookie('languageCookie[defaultLanguage]' , $default_language, time() - 7776100);
}
function setcookies($browser_language, $default_language, $language, $languagepage, $brlang_path){
    if(isset($_GET['lang']) && file_exists($languagepage)) cookie2($browser_language, $default_language, $language);
    if(!isset($_COOKIE) && file_exists($brlang_path)) cookie3($default_language, $language, $browser_language);
    if(!file_exists($brlang_path)) cookie1($browser_language, $language, $default_language);
}
function requireonceget($language, $browser_language, $default_language){
    require_once("$language/index_$language.php");
    setcookies($browser_language, $default_language, $language, $languagepage, $brlang_path);
}
function cookiefunction($brlang_path , $languagepage , $default_language){ 
    if(isset($_COOKIE['languageCookie']['browserLanguage'])) require_once($brlang_path);
    if(isset($_COOKIE['languageCookie']['language'])) require_once($languagepage);
    if(isset($_COOKIE['languageCookie']['defaultLanguage'])) require_once($default_language);
}
function browserlanguage($browser_language, $default_language, $language){
    require_once("$browser_language/index_$browser_language.php");
    setcookies($browser_language, $default_language, $language, $languagepage, $brlang_path);
}
function defaultlanguage($default_language, $browser_language, $language){
    require_once("en/index_en.php");
    setcookies($browser_language, $default_language, $language, $languagepage, $brlang_path);
}
function autolanguage($brlang_path, $browser_language, $default_language, $language){
    (file_exists($brlang_path)) ? browserlanguage($browser_language, $default_language) : defaultlanguage($default_language, $browser_language, $language);
}

if(isset($_GET['lang'])) (file_exists($languagepage) ? requireonceget($language, $browser_language, $default_language) : require_once($error_language_not_exist));
(isset($_COOKIE)) ? cookiefunction($brlang_path , $languagepage , $default_language): autolanguage($brlang_path, $browser_language, $default_language, $language);
