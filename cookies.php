<?php
session_start();

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
    require_once 'errors/error-lang-404.php';
}

function isAcceptedLanguage(string $language): bool {
    static $acceptedLanguages = ['de', 'en'];
    return in_array($language, $acceptedLanguages);
}

function setLanguageCookie(string $language): void {
    setcookie('language', $language, strtotime('+90 days'));
}
