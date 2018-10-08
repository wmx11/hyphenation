<?php

namespace Inc;

use PDO;
use PDOException;

class Database
{
    private $localhost = 'localhost';
    private $user = 'root';
    private $password = 'password';
    private $database = 'hyphenation';
    private $connection;

    private $patterns = [];
    private $words = [];
    private $hyphenatedWords = [];

    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=$this->localhost;dbname=$this->database", $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected";
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }

        $this->getPatternsFromDb();
        $this->getWordsFromDb();
        $this->getHyphenatedWordFromDb();
    }

    public function __destruct()
    {
        $this->connection = null;
    }

    public function connect()
    {
        return $this->connection;
    }

    public function insertPatterns($pattern)
    {
        $stmt = $this->connection->prepare("INSERT INTO patterns (pattern) VALUES (:pattern)");
        $stmt->bindParam(':pattern', $pattern);
        $stmt->execute();
    }

    public function insertWords($word)
    {
        $stmt = $this->connection->prepare("INSERT INTO words (word) VALUES (:word)");
        $stmt->bindParam(':word', $word);
        $stmt->execute();
    }

    public function insertHyphenatedWord($wordId, $hyphenatedWord)
    {
        if (empty($this->hyphenatedWords[$wordId])) {
            $stmt = $this->connection->prepare("INSERT INTO hyphenated_words (word_id, hyphenated_word) VALUES (:word_id, :hyphenated_word)");
            $stmt->bindParam(':word_id', $wordId);
            $stmt->bindParam(':hyphenated_word', $hyphenatedWord);
            $stmt->execute();
            echo "$wordId => $hyphenatedWord Inserted \r\n";
        }
    }

    public function getPatternsFromDb()
    {
        $stmt = $this->connection->query("SELECT * FROM patterns")->fetchAll();
        foreach ($stmt as $id => $row) {
            $this->patterns[$row['id']] = $row['pattern'];
        }
    }

    public function getWordsFromDb()
    {
        $stmt = $this->connection->query("SELECT * FROM words ORDER BY id LIMIT 50")->fetchAll();
        foreach ($stmt as $id => $row) {
            $this->words[trim($row['id'])] = trim($row['word']);
        }
    }

    public function getHyphenatedWordFromDb()
    {
        $stmt = $this->connection->query("SELECT * FROM hyphenated_words")->fetchAll();
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