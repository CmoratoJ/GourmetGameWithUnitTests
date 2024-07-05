<?php

namespace core\library;

class Question
{
    public function initialQuestion(int $type = 0):string
    {
        if ($type === 1) {
            return 'O prato que você pensou é doce ?';
        }
        return 'O prato que você pensou é bolo de chocolate ?';
    }

    public function nextQuestions(string $answer):string
    {
        return "O prato que você pensou é {$answer} ?";
    }

    public function newQuestionDishName():string
    {
        return "Qual prato você pensou ?";
    }

    public function newQuestionDishType(string $name, string $oldName):string
    {
        return  "{$name} é ____ mas {$oldName} não.";
    }

    public function scrollQuestions(array $data)
    {
        $name = '';
        foreach ($data as $key => $question) {
            $answer = readline("{$question} (S/N) ");
            if ($answer === 's' && $key === 'name') {
                return true;
            }
            $name =  $key === 'name' ? $this->extractNameFromQuestion($question, 'é', '?') : '';
        }

        return $name;
    }

    public function extractNameFromQuestion($string, $startChar, $endChar) {
        $startPos = strpos($string, $startChar);
        if ($startPos === false) {
            return false;
        }
        
        $startPos += strlen($startChar);
        $endPos = strpos($string, $endChar, $startPos);
        
        if ($endPos === false) {
            return false;
        }
        
        return substr($string, $startPos, $endPos - $startPos);
    }

    public function createNewQuestion(string $oldDishName)
    {
        $newDishName = readline($this->newQuestionDishName());
        $newDishType = readline($this->newQuestionDishType($newDishName, $oldDishName));

        return $this->insertQuestion(
            $this->nextQuestions($newDishType),
            $this->nextQuestions($newDishName)
        );
    }

    public function insertQuestion(string $type, string $name)
    {
        return [
            "type" => $type,
            "name" => $name
        ];
    }
}
