<?php

$botToken = "bottoken";
$website = "https://api.telegram.org/bot" . $botToken;

$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);


$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];


switch ($message) {

    case "/about":
        sendMessage($chatId,
            "This bot has been created for : `Computer Software & IOS-Android - Question/Answers` And it will help the others to find what they were looking for.
             ");
        break;
    case "/contact":
        sendMessage($chatId,
            "Contact me via : Ash.wxrz@hotmail.com Or you can find me in Telegram with : `LinX64` Username.");
        break;
    case "/github":
        sendMessage($chatId,
            "Here is the Github link of this Bot, if you'd like to change or making
this Bot Better than before.

             Github : github.com/LinX64/TelegramBot-Computer-Software");
        break;
    default:
        sendMessage($chatId,
            "Welcome!, Please read the rules first and don't be shy to ask anything about this Bot or about the Group!

                 Rules :

                    1. Before asking anything, make sure you've searched the
                      question already!

                      2. We don't talk too much here and this group is not a
                       'ChatRoom'.

                 ** The new rules will be added soon");
}

function sendMessage($chatId, $message)
{

    $url = $GLOBALS[website] . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message);
    file_get_contents($url);

}

?>