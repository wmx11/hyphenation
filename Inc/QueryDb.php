<?php

namespace Inc;

class QueryDb
{
    private $patterns = [];
    private $words = [];
    private $hyphenatedWords = [];
    private $con;
    private $connection;

    public function __construct()
    {
        $this->con = new Database();
        $this->connection = $this->con->connect();
        $this->getPatternsFromDb();
        $this->getWordsFromDb();
        $this->getHyphenatedWordFromDb();
    }

    public function insertPatterns($pattern)
    {
        $this->con->insert('patterns', $pattern);
    }

    public function insertWords($word)
    {
        $this->con->insert('words', $word);
    }

    public function insertHyphenatedWord($wordId, $hyphenatedWord, $data)
    {
        if (empty($this->hyphenatedWords[$wordId])) {
            $this->con->insert('hyphenated_words', $data);
            echo "$wordId => $hyphenatedWord Inserted \r\n";
        }
    }

    public function insertFoundPatterns($wordId, $foundPatterns)
    {
        if (empty($this->hyphenatedWords[$wordId])) {
            $patternId = [];
            foreach ($foundPatterns as $positionInWord => $pattern) {
                foreach ($pattern as $patternIndex => $patternValue) {
                    $patternId[] = $patternIndex;
                }
            }

            foreach ($patternId as $foundPatternId) {
                $data = [
                    'word_id' => $wordId,
                    'pattern_id' => $foundPatternId
                ];
                $this->con->insert('word_pattern_relation', $data);
            }
        }
    }

    public function getPatternsFromDb()
    {
        $stmt = $this->con->get('*', 'patterns');
        foreach ($stmt as $id => $row) {
            $this->patterns[$row['id']] = $row['pattern'];
        }
    }

    public function getWordsFromDb()
    {
        $stmt = $this->con->get('*', 'words', 'order by id desc limit 5');
        foreach ($stmt as $id => $row) {
            $this->words[trim($row['id'])] = trim($row['word']);
        }
    }

    public function getHyphenatedWordFromDb()
    {
        $stmt = $this->con->get('*', 'hyphenated_words');
        foreach ($stmt as $id => $row) {
            $this->hyphenatedWords[$row['word_id']] = $row['hyphenated_word'];
        }
    }

    public function ifWordExists($id)
    {
        if (!empty($this->hyphenatedWords[$id])) {
            echo $this->hyphenatedWords[$id] . "\r\n";
        } else {
            return false;
        }
    }

    public function returnPatterns()
    {
        return $this->patterns;
    }

    public function returnWords()
    {
        return $this->words;
    }

    public function returnHyphenatedWords()
    {
        return $this->hyphenatedWords;
    }
}