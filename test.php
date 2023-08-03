<?php


$r = is_integer(1) == is_int(1);
var_dump($r);

$json = ['a' => '大家好'];
echo json_encode($json, JSON_UNESCAPED_UNICODE);