<?php

    $string = 'i eat apples and oranges all day long';
    $find = 'and orangis';
    $distance = 1;
    $matches = preg_match_levensthein($find, $distance, $string);
    var_dump($matches);

    function preg_match_levensthein($find, $distance, $string)
    {
        $found = array();

        // Covert find into regex
        $parts = explode(' ', $find);
        $regexes = array();
        foreach ($parts as $part) {
            $regexes[] = '[a-z0-9]{' . strlen($part) . '}';
        }
        $regexp = '#' . implode('\s', $regexes) . '#i';

        // Find all matches
        preg_match_all($regexp, $string, $matches);

        foreach ($matches as $match) {
            // Check levenshtein distance and add to the found if within bounds
            if (levenshtein($match[0], $find) <= $distance) {
                $found[] = $match[0];
            }
        }

        // return found
        return $found;
    }

 ?>