<?php

function analyzeText(): string
{
    $text = $_POST['text'];

    return json_encode([
        'Number of characters' => strlen($text),
        'Number of words' => str_word_count($text),
        'Number of sentences' => count(getWords($text)),
        'Frequency of characters' => frequencyOfCharacters($text),
        'Distribution of characters as a percentage of total' => numberOfCharactersInPercent($text),
        'Average word length' => averageWordLength($text),
        'The average number of words in a sentence' => averageNumberOfWordsInSentence($text),
        'Top 10 most used words' => top10MostUsedWords($text),
        'Top 10 longest words' => descSort(getWords($text)),
        'Top 10 shortest words' => ascSort(getWords($text)),
        'Top 10 longest sentences' => descSort(getSentences($text)),
        'Top 10 shortest sentences' => ascSort(getSentences($text)),
        'Number of palindrome words' => count(getPalindromes($text)),
        'Top 10 longest palindrome words' => descSort(getPalindromes($text)),
        'Is the whole text a palindrome' => isPalindrome($text),
        'Date and time' => date('Y-m-d h:i:sa'),
        'The reversed text' => strrev($text),
        'The reversed words' => implode(' ', array_reverse(getWords($text))),
    ]);
}

function frequencyOfCharacters(string $text): array
{
    $text = preg_replace('/\s+/', '', $text);
    $result = [];

    foreach (count_chars($text, 1) as $char => $number) {
        $result[chr($char)] = $number;
    }

    return $result;
}

function numberOfCharactersInPercent(string $text): array
{
    $text = preg_replace('/\s+/', '', $text);
    $textLen = strlen($text);
    $result = [];

    foreach (count_chars($text, 1) as $char => $number) {
        $result[chr($char)] = number_format((100.0 * $number) / $textLen, 2);
    }

    return $result;
}

function averageWordLength(string $text): int
{
    $wordsCount = $wordsLength = 0;

    $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($words as $word) {
        $wordsCount++;
        $wordsLength += strlen($word);
    }

    return intdiv($wordsLength, $wordsCount);
}

function averageNumberOfWordsInSentence($text): float
{
    $sentences = preg_split('/(?<=[.?!;:])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
    $numberOfWords = 0;

    if (is_array($sentences)) {
        foreach ($sentences as $key => $sentence) {
            $numberOfWords += str_word_count($sentence);
        }
    }

    return round($numberOfWords / count($sentences));
}

function top10MostUsedWords(string $text): array
{
    $words = array_count_values(getWords($text));
    arsort($words);
    return array_slice(array_keys($words), 0, 10, true);
}

function getWords(string $text): array
{
    return array_unique(preg_split("/\s+/", $text));
}

function getSentences(string $text): array
{
    return array_unique(preg_split('/(?<=[.?!;:])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY));
}

function descSort(array $array): array
{
    usort($array, function ($a, $b) {
        return strlen($b) <=> strlen($a);
    });

    return array_slice($array, 0, 10);
}

function ascSort(array $array): array
{
    usort($array, function ($a, $b) {
        return strlen($a) <=> strlen($b);
    });

    return array_slice($array, 0, 10);
}

function getPalindromes(string $text): array
{
    $palindromes = [];
    foreach (getWords($text) as $word) {
        if (isPalindrome($word)) {
            $palindromes[] = $word;
        }
    }

    return array_unique($palindromes);
}

function isPalindrome(string $text): bool
{
    for ($i = 0, $j = strlen($text) - 1; $j > $i; $i++, $j--) {
        if ($text[$i] != $text[$j]) {
            return false;
        }
    }

    return true;
}
