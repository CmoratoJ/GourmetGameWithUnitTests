<?php

namespace app\library;

use core\library\Question;

class Game
{
    private array $questions;
    protected Question $question;

    public function __construct()
    {
        $this->question = new Question;
    }

    public function play(bool $next = false)
    {
        if (!$next) {
            $this->questions = $this->question->insertQuestion(
                $this->question->initialQuestion(1), 
                $this->question->initialQuestion()
            );
        }

        $response = $this->question->scrollQuestions($this->questions);

        if (is_bool($response)) {
            $this->end();
            $this->play();
        }

        $this->questions = $this->question->createNewQuestion($response);
        $this->play(true);        
    }

    private function end()
    {
        readline("Acertei de novo !");
    }
}
