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
*/
$botman->hears('yo', BotManController::class.'@startConversation');

$botman->hears('カテゴリ', function($bot){
   $cate =  DB::select('select distinct category_view from restaurant;');
   $string = "";
   for ($i = 0 ; $i < count($cate); $i++) {
        $string .= $cate[$i]->category_view."\n";  
   }
   $bot->reply(">".$string);
});

$botman->hears('(ランチ|らんち|lunch)( |　)+{msg}', function ($bot, $msg) {
    $cate = "%".$msg."%";
    $lunch = DB::select('select * from restaurant WHERE category_view LIKE ? order by RANDOM() limit 3', [$cate]);
    if(count($lunch) < 3){
        $lunch = DB::select('select * from restaurant order by RANDOM() limit 3');
    }
    $bot->reply("> <".$lunch[0]->url."|".$lunch[0]->name.">\t".$lunch[0]->category_view."\t".$lunch[0]->lunch."円   徒歩".$lunch[0]->walking."分\n><".$lunch[1]->url."|".$lunch[1]->name.">\t".$lunch[1]->category_view."\t".$lunch[1]->lunch."円   徒歩".$lunch[1]->walking."分\n><".$lunch[2]->url."|".$lunch[2]->name.">\t".$lunch[2]->category_view."\t".$lunch[2]->lunch."円   徒歩".$lunch[2]->walking."分");
    });

// $botman->hears('(ランチ|らんち|lunch)', function ($bot) {
//     $lunch = DB::select('select * from restaurant order by RANDOM() limit 3');
//     $bot->reply("> <".$lunch[0]->url."|".$lunch[0]->name.">\t".$lunch[0]->category_view."\t".$lunch[0]->lunch."円   徒歩".$lunch[0]->walking."分\n><".$lunch[1]->url."|".$lunch[1]->name.">\t".$lunch[1]->category_view."\t".$lunch[1]->lunch."円   徒歩".$lunch[1]->walking."分\n><".$lunch[2]->url."|".$lunch[2]->name.">\t".$lunch[2]->category_view."\t".$lunch[2]->lunch."円   徒歩".$lunch[2]->walking."分");
// });