session_start();

$language = $_GET['lang'] ?? "en";
$languagepage = "$language/index_$language.php";
$error_language_not_exist = "errors/error-lang-404.php";
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$acceptLang = ['de','en']; 
$browser_language = in_array($lang, $acceptLang) ? $lang : 'en';  
$brlang_path = "$browser_language/index_$browser_language.php";
$default_language = "en/index_en.php";

function requireonceget($language, $browser_language, $default_language){
    require_once("$language/index_$language.php");
    setcookie('languageCookie[language]' , $language, strtotime('+90 days'));
    setcookie('languageCookie[browserLanguage]' , $browser_language, time() - 7776100);
    setcookie('languageCookie[defaultLanguage]' , $default_language, time() - 7776100);
}
function cookiefunction($brlang_path , $languagepage , $default_language){ 
    if(isset($_COOKIE['languageCookie']['browserLanguage'])) require_once($brlang_path);
    if(isset($_COOKIE['languageCookie']['language'])) require_once($languagepage);
    if(isset($_COOKIE['languageCookie']['defaultLanguage'])) require_once($default_language);
}
function browserlanguage($browser_language, $default_language){
    require_once("$browser_language/index_$browser_language.php");
    setcookie('languageCookie[browserLanguage]' , $browser_language, strtotime('+90 days'));
    setcookie('languageCookie[defaultLanguage]' , $default_language, time() - 7776100);
    setcookie('languageCookie[language]' , $language, time() - 7776100);
}
function defaultlanguage($default_language, $browser_language, $language){
    require_once("en/index_en.php");
    setcookie('languageCookie[defaultLanguage]' , $default_language, strtotime('+90 days'));
    setcookie('languageCookie[browserLanguage]' , $browser_language, time() - 7776100);
    setcookie('languageCookie[language]' , $language, time() - 7776100);
}
function autolanguage($brlang_path){
    (file_exists($brlang_path)) ? browserlanguage() : defaultlanguage();
}

if(isset($_GET['lang'])) (file_exists($languagepage) ? requireonceget() : require_once($error_language_not_exist));
(isset($_COOKIE)) ? cookiefunction(): autolanguage();
