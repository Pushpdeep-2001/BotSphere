<?php
include 'core/init.php';

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>MyChatGPT - Your Own Custom ChatGPT Clone</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <div class="wrapper flex flex-1">
        <div class="inner-wrapper flex flex-1">
            <div class="flex flex-1 w-full h-screen">
                <!--ChatBot_SECTION-->
                <div class="w-full flex flex-1 flex-col items-center justify-center bg-gray-700" style="flex:6;">
                    <div class="w-full flex flex-col flex-1 justify-center items-center border-t border-b">
                        <div class="flex items-start flex-1">
                            <div class="flex justify-space-between relative top-60">
                                <!-- Ai-Bots-Here -->
                                <?php
                                $i = 1;
                                foreach ($chatObj->getChatBots() as $bot) :
                                ?>
                                    <div class="px-4 mx-2 flex flex-col hover:border-4 transition-all hover:cursor-pointer rounded-2xl border-green-400 p-2 bg-gray-600 text-gray-700">
                                        <div class="py-2 rounded-2xl w-64 overflow-hidden">
                                            <img src="assets/images/bot-<?php echo $i; ?>.png" />
                                        </div>
                                        <div class="py-2 w-60 items-center justify-center flex flex-col text-center text-white">
                                            <h1 class="text-xl font-bold py-2"><?php echo $bot->name; ?></h1>
                                            <p><?php echo $bot->description; ?></p>
                                        </div>
                                        <a href="chat.php?bot=<?php echo $bot->ID; ?>">
                                            <div class="flex justify-center	py-2"><button class="w-40 mb-1 py-2 px-2 text-gray-700 rounded font-semibold shadow-md bg-white hover:bg-green-400">Start Chat</button></div>
                                        </a>
                                    </div>

                                <?php
                                    $i++;
                                endforeach;
                                ?>

                                <!-- Ai-Bots-Here -->
                            </div>
                        </div>

                    </div>
                </div><!--ChatBot_SECTION_END-->
            </div>
        </div>
    </div>
</body>

</html>