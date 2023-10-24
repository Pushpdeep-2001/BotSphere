<?php
include 'classes/DB.php';
include 'classes/Chat.php';
require __DIR__ . '/../vendor/autoload.php';

use Orhanerday\OpenAi\OpenAi;

$token = "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";
$openAi = new OpenAi($token);
$chatObj = new Chat;
