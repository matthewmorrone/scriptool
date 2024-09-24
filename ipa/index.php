<?php
error_reporting(0);

ini_set("memory_limit", "256M");

include "str_pad_unicode.php";

$input = $_GET["input"];

$file = file("cmu-ipa-umbrian.tsv");

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
$input = str_replace(["’"], "", $input);
$input = preg_split('/\b/', $input);
$input = array_map("trim", $input);
$input = array_filter($input);

foreach($input as &$word):
	if ($dict[$word]) {
		$word = $dict[$word];
	}
	else if (preg_match("/[\.,:;—\?\!]/", $word)) {
		$word = "<span class='punct'>$word</span>";
	}
	else {
		$word = "<span class='notfound'>$word</span>";
	}
endforeach;

print_r(implode(" ", $input));

ini_set("memory_limit", "128M");

