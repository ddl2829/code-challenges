<?php

require "vendor/autoload.php";

/*


 */

$input = file_get_contents("data/day7");

$lines = explode("\n", $input);
$directories = [
    '/' => [
        'path' => '',
        'name' => '/',
        'parent' => ['path' => ''],
        'type' => 'directory',
        'children' => [

        ],
        'size' => 0
    ]
];

$currentNode = &$directories['/'];

$pathsUnder100k = [];
$totalSize = [];

foreach($lines as $index => $line) {

    $currentNode['size'] = collect($currentNode['children'])->sum('size');
    $totalSize[$currentNode['path']] = $currentNode['size'];
    if($currentNode['size'] < 100_000) {
        $pathsUnder100k[$currentNode['path']] = $currentNode['size'];
    } else {
        if(isset($pathsUnder100k[$currentNode['path']])) {
            unset($pathsUnder100k[$currentNode['path']]);
        }
    }

    $matches = [];
    if($line[0] === '$') {
        preg_match('/\$\s(\w+)[\s]?([\w\/\.]+)?/', $line, $matches);
        //print_r($matches);
        if($matches[1] === 'cd') {
            // set the current node's size based on it's children
            if($matches[2] === '/') {
                continue;
            }
            if($matches[2] === '..') {
                $currentNode = &$currentNode['parent'];
                continue;
            }
            $currentNode = &$currentNode['children'][$matches[2]];
        }
        if($matches[1] === 'ls') {
            // do nothing
        }
    } else {
        preg_match('/(dir|[\d]+) (.+)/', $line, $matches);
        if($matches[1] === 'dir') {
            $currentNode['children'][$matches[2]] = [
                'type' => 'directory',
                'path' => $currentNode['path'] . '/' . $matches[2],
                'name' => $matches[2],
                'parent' => &$currentNode,
                'children' => [

                ],
                'size' => 0
            ];
        } else {
            $currentNode['size'] += intval($matches[1]);
            $currentNode['children'][$matches[2]] = [
                'path' => $currentNode['path'] . '/' . $matches[2],
                'name' => $matches[2],
                'type' => 'file',
                'size' => $matches[1]
            ];
        }
    }
}

while($currentNode['name'] !== '/') {
    $currentNode['size'] = collect($currentNode['children'])->sum('size');
    $totalSize[$currentNode['path']] = $currentNode['size'];
    $currentNode = &$currentNode['parent'];
}
$currentNode['size'] = collect($currentNode['children'])->sum('size');
$totalSize[$currentNode['path']] = $currentNode['size'];

echo collect($pathsUnder100k)->sum();

echo "\n";
$lookingFor = 30_000_000 - (70_000_000 - $directories['/']['size']);
echo "Looking for $lookingFor\n";

//print_r($totalSize);
//print_r(collect($totalSize)->sort()->toArray());

$candidates = [];
foreach($totalSize as $path => $size) {
    if($size >= $lookingFor) {
        $candidates[$path] = $size;
    }
}

print_r(collect($candidates)->sort()->toArray());