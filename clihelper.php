<?php


/*function readline($prompt = ' : ')
{
    echo $prompt;
    return stream_get_line(STDIN, 1024, PHP_EOL);
}*/

function newline($count = 1)
{
    for ($i = 0; $i < $count; $i++)
    {
        echo "\n";
    }
}

function echoAll($array, $prefix = "", $postfix = "\n")
{
    foreach($array as $x)
    {
        echo $prefix.$x.$postfix;
    }
}

function table($data, &$totalLength)
{
    // Find longest string in each column
    $tLength = 0;
    $columns = [];
    foreach ($data as $row_key => $row) {
        foreach ($row as $cell_key => $cell) {
            $length = strlen($cell);
            if (empty($columns[$cell_key]) || $columns[$cell_key] < $length) {
                $columns[$cell_key] = $length;
            }
        }
    }
    foreach ($columns as $col)
    {
        $tLength += $col;
    }
    $totalLength = $tLength;
    
    // Output table, padding columns
    $table = '';
    foreach ($data as $row_key => $row) {
        foreach ($row as $cell_key => $cell)
            $table .= str_pad($cell, $columns[$cell_key]) . '   ';
        $table .= PHP_EOL;
    }
    return $table;
}


$foreground_colors = [
    'black' => '0;30',
    'dark_gray' => '1;30',
    'blue' => '0;34',
    'light_blue' => '1;34',
    'green' => '0;32',
    'light_green' => '1;32',
    'cyan' => '0;36',
    'light_cyan' => '1;36',
    'red' => '0;31',
    'light_red' => '1;31',
    'purple' => '0;35',
    'light_purple' => '1;35',
    'brown' => '0;33',
    'yellow' => '1;33',
    'light_gray' => '0;37',
    'white' => '1;37',
];
$background_colors = [
'black' => '40',
'red' => '41',
'green' => '42',
'yellow' => '43',
'blue' => '44',
'magenta' => '45',
'cyan' => '46',
'light_gray' => '47', 
];

function colorize($string, $fColor = null, $bColor = null) {
    $colored_string = "";

    // Check if given foreground color found
    if (isset($foreground_colors[$fColor])) {
        $colored_string .= "\033[" . $foreground_colors[$fColor] . "m";
    }
    // Check if given background color found
    if (isset($background_colors[$bColor])) {
        $colored_string .= "\033[" . $background_colors[$bColor] . "m";
    }

    // Add string and end coloring
    $colored_string .= $string . "\033[0m";

    return $colored_string;
}

// Returns all foreground color names
function getForegroundColors() {
    return array_keys($foreground_colors);
}

// Returns all background color names
function getBackgroundColors() {
    return array_keys($background_colors);
}

function is_decimal($val)
{
    return is_numeric($val) && floor($val) != $val;
}

function array_find($array, &$index, $callback, $params  = [])
{
    $array = array_values($array);
    for($i = 0; $i < count($array); $i++)
    {
        $args = [];
        $args[] = $array[$i];
        
        if ($params) $args = array_merge ($args, $params);
                
        $index = $i;
        if(call_user_func_array($callback, $args)) return true;
    }
    $index = -1;
    return false;
}

function array_get($array, $callback, $params  = [])
{
    $array = array_values($array);
    for($i = 0; $i < count($array); $i++)
    {
        $args = [];
        $args[] = $array[$i];
        
        if ($params) $args = array_merge ($args, $params);
                
        $index = $i;
        if(call_user_func_array($callback, $args)) return $array[$i];
    }
    $index = -1;
    return false;
}