<?php
error_reporting(0);
// argument 1: optional, include inflection marker column, defaults to false
// argument 2: optional, limit number of rows

// example: php main.php cmu.ipa.tsv > cmudict.ipa.tsv

ini_set("memory_limit", "256M");

include "str_pad_unicode.php";

// $input = file($argv[1]);
$input = $_GET["input"];

$file = file("cmu-ipa-no-stress.tsv");

$inflections = ($argv[1] || false);

$map[1] = "ˈ";
$map[2] = "ˌ";

foreach($file as &$line):
	$line = explode("\t", $line);
	$line = array_map("trim", $line);
	$map[$line[0]] = $line[1];
endforeach;
foreach($file as &$line):
	$dict[$line[0]] = $line[1];
endforeach;

$input = strtolower($input);
$input = str_replace([",", ".", ";", ":", "’"], "", $input);
$input = str_replace(["—"], " ", $input);
$input = explode(" ", $input);

foreach($input as &$word):
	if ($dict[$word]) $word = $dict[$word];
endforeach;

print_r(implode(" ", $input));

ini_set("memory_limit", "128M");

