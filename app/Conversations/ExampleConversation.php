<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use DB;
use App\Conversations\ExampleConversation;


class ExampleConversation extends Conversation
{
    /*
     * First question
     */
    public function askReason()
    {
        $lunch = DB::select('select * from restaurant order by RANDOM() limit 3');
        $question = Question::create("1: <".$lunch[0]->url."|".$lunch[0]->name.">\t".$lunch[0]->category_view."\t".$lunch[0]->lunch."\n2: ".$lunch[1]->name."\t".$lunch[1]->category_view."\t".$lunch[1]->lunch."\n3: ".$lunch[2]->name."\t".$lunch[2]->category_view."\t".$lunch[2]->lunch)
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('1')->value('1'),
                Button::create('2')->value('2'),
                Button::create('3')->value('3'),
                Button::create('もう一度')->value('again'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === '1') {
                    $this->say($lunch[0]->url);
                } elseif($answer->getValue() === '2'){
                    $this->say($lunch[1]->url);
                } elseif ($answer->getValue() === '3'){
                    $this->say($lunch[2]->url);
                } else{
                    $this->say(":yaruo:");
                }
            }
        });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
