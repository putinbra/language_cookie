<?php

if(isset($_POST['cookie'])) {
    setcookie('allowed',true,strtotime("365 days"));
}

$acceptedLanguages  = ['de', 'en'];
$language = 'en';

    if (isset($_GET['lang'])) {
        if (isAcceptedLanguage($_GET['lang'])) {
            $language = $_GET['lang'];
            setLanguageCookie($language);
        }
    } elseif (isset($_COOKIE['language'])) {
        $language = $_COOKIE['language'];
    } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

        foreach ($languages as $tempLanguage) {
            if (isAcceptedLanguage($tempLanguage)) {
                $language = $tempLanguage;
                setLanguageCookie($language);
                break;
            }
        }
    }

    $path = $language . '/index.php';

    if (file_exists($path)) {
        require_once $path;
    } else {
        require_once 'C:xampp\htdocs\Website/errors/error-lang-404.php';
    }

    function isAcceptedLanguage(string $language): bool
    {
        static $acceptedLanguages = ['de', 'en'];
        return in_array($language, $acceptedLanguages);
    }

    function setLanguageCookie(string $language): void
    {
        setCookieIfAllowed('language', $language, strtotime('+90 days'));
    }

function setCookieIfAllowed(string $name,string $value = "", int $expires = 0 , string $path = "" , string $domain = "" , bool $secure = false , bool $httponly = false ):bool {

    $cookiesAllowed = isset($_COOKIE['allowed']);
    if(false===$cookiesAllowed){
        return false;
    }

    return setcookie($name,$value,$expires,$path,$domain,$secure,$httponly);

}
