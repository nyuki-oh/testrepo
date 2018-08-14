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

$botman->hears('{mes}', function ($bot, $mes) {
    $bot->reply($mes);
});

$botman->hears('Start conversation', BotManController::class.'@startConversation');
*/
$botman->hears('.*(ランチ|らんち|lunch).*', function ($bot) {
    $lunch = DB::select('select * from restaurant order by RANDOM() limit 3');
    $bot->reply($lunch[0]->name."\t".$lunch[0]->category_view."\t".$lunch[0]->lunch."\n".$lunch[1]->name."\t".$lunch[1]->category_view."\t".$lunch[1]->lunch."\n".$lunch[2]->name."\t".$lunch[2]->category_view."\t".$lunch[2]->lunch);
});