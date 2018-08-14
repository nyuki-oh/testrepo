<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');
/*
$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});

$botman->hears('ping', function ($bot) {
    $bot->reply('pong');
});
*/
$botman->hears('{mes}', function ($bot, $mes) {
    $bot->reply($mes);
});

$botman->hears('Start conversation', BotManController::class.'@startConversation');
