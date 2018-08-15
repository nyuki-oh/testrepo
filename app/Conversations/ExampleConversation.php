<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use DB;

class ExampleConversation extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $lunch = DB::select('select * from restaurant order by RANDOM() limit 3');
        $question = Question::create($lunch[0]->name.'\t'.$lunch[0]->category_view.'\t'.$lunch[0]->lunch.'\n'.$lunch[1]->name.'\t'.$lunch[1]->category_view.'\t'.$lunch[1]->lunch.'\n'.$lunch[2]->name.'\t'.$lunch[2]->category_view.'\t'.$lunch[2]->lunch)
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('1')->value('joke'),
                Button::create('2')->value('quote'),
                Button::create('3')->value('quote'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'joke') {
                    $joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                    $this->say($joke->value->joke);
                } else {
                    $this->say(Inspiring::quote());
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
