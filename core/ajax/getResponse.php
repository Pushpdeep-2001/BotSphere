<?php

include '../init.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST)) {
        $prompt = $_POST['prompt'];
        $botID   = $_POST['botID'];

        $bot     = $chatObj->getBot($botID);

        if (!empty($prompt)) {
            if ($bot) {
                $messages = $chatObj->getChat($bot->ID);
                $conversation = [];
                $conversation[] = ["role" => "system", "content" => $bot->role];

                foreach ($messages as $row) {
                    if ($row->author === "User") {
                        $role = 'user';
                        $content = $row->text;
                    } else {
                        $role = 'assistant';
                        $content = $row->text;
                    }

                    $message = [
                        'role' => $role,
                        'content' => $content
                    ];

                    $conversation[] = $message;
                }

                $conversation[] = ["role" => "system", "content" => $bot->role];

                $chat = $openAi->chat([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => $conversation,
                    'temperature' => 0.9,
                    'max_tokens' => 150,

                ]);

                $data = json_decode($chat);
                //var_dump($data);
                $message = $data->choices[0]->message->content;
                $chatObj->storeMessages($message, 'AI', $bot->ID);

                header('Content-Type: application/json');
                echo json_encode($message);
            }
        }
    }
}

// $message = "This is a message from ChatGPT";

// header('Content-Type: application/json');
// echo json_encode($message);
