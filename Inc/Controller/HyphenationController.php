<?php

namespace Inc\Controller;

class HyphenationController
{
    private $con;
    private $words = array ();
    private $patterns = array ();
    private $hyphenatedWords = array ();

    public function __construct($db)
    {
        $this->con = $db;
        $this->getWordsFromDb();
        $this->getPatternsFromDb();
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
            $patternId = array ();
            foreach ($foundPatterns as $positionInWord => $pattern) {
                foreach ($pattern as $patternIndex => $patternValue) {
                    $patternId[] = $patternIndex;
                }
            }

            foreach ($patternId as $foundPatternId) {
                $data = array (
                    'word_id' => $wordId,
                    'pattern_id' => $foundPatternId
            );
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
        $stmt = $this->con->get('*', 'words', 'order by id asc limit 135');
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

    public function insertTransaction()
    {
        try {
            $data = array (
                'word_id' => 666,
                'hyphenated_word' => 'ba-na-na-na-na'
            );

            $this->con->beginTransaction();
            $this->con->insert('hyphenated_words', $data);
            $this->con->commit();
        } catch (\Exception $e) {
            echo $e->getMessage();
            $this->con->rollBack();
        }
    }
}