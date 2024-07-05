<?php

namespace tests\unit\core\library;

use core\library\Question;
use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    protected Question $question;

    public function setUp():void
    {
        $this->question = new Question;
    }

    public function test_initial_question()
    {
        $question = $this->question->initialQuestion();

        $this->assertEquals('O prato que você pensou é bolo de chocolate ?', $question);
    }

    public function test_initial_question_type()
    {
        $question = $this->question->initialQuestion(1);

        $this->assertEquals('O prato que você pensou é doce ?', $question);
    }

    public function test_next_questions()
    {
        $question = $this->question->nextQuestions('chocolate');

        $this->assertEquals('O prato que você pensou é chocolate ?', $question);
    }

    public function test_new_question_dish_name()
    {
        $question = $this->question->newQuestionDishName();

        $this->assertEquals('Qual prato você pensou ?', $question);
    }

    public function test_new_question_dish_type()
    {
        $question = $this->question->newQuestionDishType('chocolate', 'bolo de chocolate');

        $this->assertEquals('chocolate é ____ mas bolo de chocolate não.', $question);
    }

    public function test_create_new_question()
    {
        $question = $this->question->createNewQuestion('chocolate');

        $this->assertArrayHasKey('type', $question);
        $this->assertArrayHasKey('name', $question);
    }

    public function test_insert_question()
    {
        $question = $this->question->insertQuestion('salgado', 'pastel');

        $this->assertArrayHasKey('type', $question);
        $this->assertArrayHasKey('name', $question);
    }

    public function test_scroll_questions()
    {
        $question = $this->question->insertQuestion(
            $this->question->initialQuestion(1), 
            $this->question->initialQuestion()
        );

        $response = $this->question->scrollQuestions($question);

        if (is_bool($response)) {
            $this->assertEquals(true, $response);
        } else {
            $this->assertEquals(' bolo de chocolate ', $response);
        }
    }

    public function test_stract_name_from_question()
    {
        $response = $this->question->extractNameFromQuestion('O prato que você pensou é bolo de chocolate ?', 'é', '?');

        $this->assertEquals(' bolo de chocolate ', $response);
    }
}
