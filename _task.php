<?php

$inputs = [
    '[1,2,3]',
    '[1,2 , 3]',
    '[1,20 , 3]',
    '[1, "test ", 3]',
    '[1, "test ", [ 4, 5, 6], 3]'
];

foreach ($inputs as $input) {
    $foundReplaces = 0;
    $output = [];
    $input = trim($input, '[]');

    $regex = '/\[[^\]]*\]/'; // regex to match array
    preg_match_all($regex, $input, $matches);

    $input = preg_replace($regex, '_replaced', $input);
    $items = explode(',', $input);

    foreach ($items as $item) {
        $item = convertString($item);

        if ($item === '_replaced') {
            $item = parseToArray($matches[0][$foundReplaces]);
            $foundReplaces++;
            $output[] = $item;
            continue;
        }

        $output[] = $item;
    }

    echo 'Output: <br/>';
    var_dump($output);
    echo '<br/>';
}

function convertString($string)
{
    $string = str_replace('"', '', $string, $count);
    $isNumeric = is_numeric($string);
    $string = $isNumeric === false ? ltrim($string) : $string;

    if ($isNumeric === false) {
        return $string;
    }

    $isDouble = strpos($string, '.') !== false;

    return $isDouble !== false ? (float)$string : (int)$string;
}

function parseToArray($string)
{
    $array = [];
    $string = trim($string, '[]');
    $string = str_replace(' ', '', $string);

    $items = explode(',', $string);
    foreach ($items as $item) {
        $item = is_numeric($item) !== false ? (int)$item : $item;

        $array[] = $item;
    }

    return $array;
}
