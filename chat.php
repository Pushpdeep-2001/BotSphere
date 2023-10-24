<?php
include 'core/init.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['bot'])) {
        $botID = $_GET['bot'];
        $bot   = $chatObj->getBot($botID);

        if ($bot) {
            $chat = $chatObj->getChat($bot->ID);
        } else {
            header('Location: index.php');
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>MyChatGPT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="assets/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" integrity="sha512-vswe+cgvic/XBoF1OcM/TeJ2FW0OofqAVdCZiEYkd6dwGXthvkSFWOoGGJgS2CW70VK5dQM5Oh+7ne47s74VTg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-highlight/prism-line-highlight.min.css" integrity="sha512-nXlJLUeqPMp1Q3+Bd8Qds8tXeRVQscMscwysJm821C++9w6WtsFbJjPenZ8cQVMXyqSAismveQJc0C1splFDCA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
</head>

<body>

    <div class="wrapper flex flex-1">
        <div class="inner-wrapper flex flex-1">
            <div class="flex flex-1 w-full h-screen">
                <div class="flex flex-col bg-gray-900 flex-1 h-full">
                    <div class="flex-col flex justify-space-between h-full">
                        <div class="flex flex-col h-full">
                            <div class="flex flex-col flex-1 h-full">
                                <!--LEFT_MENU_BLOCK--->
                                <div class="flex flex-col">
                                    <!--RECENT CHAT-->
                                    <div class="text-gray-400 mx-2 my-2 pt-3">
                                        <h3 style="font-size: 24px; margin: 15px;" class="text-sm font-bold">Recent Chat</h3>
                                    </div>
                                    <div>
                                        <ul class="mx-2">
                                            <!-- Recent Messages -->
                                            <?php $chatObj->getRecentChat(); ?>
                                            <!-- Recent Messages_ENDS -->
                                        </ul>
                                    </div>
                                    <!--RECENT CHAT_ENDS-->

                                    <!--BOT_SELECTION-->
                                    <div class="text-gray-400 mx-2 my-2 pt-3">
                                        <h3 style="font-size: 28px; margin: 15px;" class="text-sm font-bold">Chat Bots</h3>
                                    </div>
                                    <!-- BOT-LIST -->
                                    <?php
                                    foreach ($chatObj->getChatBots() as $botData) {
                                        echo '<!-- BOTS -->
                                        <div>
                                            <ul class="mx-2">
                                                <a href="chat.php?bot=' . $botData->ID . '">
                                                <li class="menu-list my-1 hover:bg-gray-800 rounded cursor-pointer">
                                                    <div class="flex text-white items-center">
                                                        <div class="text-white px-3 py-2 text-2xl"><i class="fas fa-robot"></i></i></div>
                                                        <div class="flex-1 relative flex items-center justify-space-between">
                                                            <span style="font-size: 20px;" class="truncate flex-2 overflow-hidden w-4/5 text-sm">' . $botData->name . '</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                </a>
                                            </ul>
                                        </div>
                                        <!-- BOTS_ENDS -->';
                                    }
                                    ?>
                                    <!-- BOT-LIST_ENDS -->
                                    <!--BOT_SELECTION-->
                                </div>
                                <!--LEFT_MENU_BLOCK--->
                            </div>
                        </div>
                    </div>
                </div>
                <!--ChatBot_SECTION-->
                <div class="w-full flex flex-1 flex-col items-end justify-center" style="flex:6;">
                    <div id="scroll" class="w-full flex flex-col items-center flex-1 bg-gray-700 overflow-y-scroll">
                        <div id="chat" class="flex flex-col flex-1 w-full h-full">
                            <!-- Messages -->
                            <?php
                            if (count($chat) === '0') {
                                echo '<!--Welcome-Message-->
						<div id="message" class="bg-gray-800 w-full flex justify-center" style="height:90vh;">
							<div class="w-1/2 flex py-10 flex-col items-center">
								<div class="flex items-center mr-5 ">
									<div class="w-96 h-auto bg-white overflow-hidden">
										<img src="assets/images/bot-1.png"/>
									</div>
								</div>
								<div class="text-white text-base">
									<div class="text-xl text-center" style="width:760px;">
										' . $bot->message . '
									</div>
								</div>
							</div>
						</div>
					<!--Welcome-Message_ENDS-->';
                            }
                            ?>
                            <?php foreach ($chat as $botData) : ?>
                                <?php if ($botData->author === "User") : ?>
                                    <!--USER_CHAT-->
                                    <div class="message w-full flex justify-center">
                                        <div class="w-1/2 h-full flex py-7">
                                            <div class="flex items-start h-full mr-5 ">
                                                <div class="w-8 h-8 overflow-hidden border border-blue-500 rounded">
                                                    <img src="assets/images/avatar.png" />
                                                </div>
                                            </div>
                                            <div id="text" class="text-white flex-1">
                                                <?php echo $botData->text; ?>
                                            </div>
                                            <div></div>
                                        </div>
                                    </div>
                                    <!--USER_CHAT_ENDS-->
                                <?php else : ?>
                                    <!--BOT_CHAT-->
                                    <div class="message bg-gray-800 w-full flex justify-center">
                                        <div class="w-1/2 h-full flex py-10">
                                            <div class="flex items-start h-full mr-5 ">
                                                <div class="w-8 h-8 bg-white overflow-hidden border border-green-500 rounded">
                                                    <img src="assets/images/mygpt.png" />
                                                </div>
                                            </div>
                                            <div id="text" class="text-white text-base flex-1">
                                                <?php echo $chatObj->getCodes($botData->text); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!--BOT_CHAT_ENDS-->
                            <?php
                                endif;
                            endforeach;
                            ?>
                            <!--space-->
                            <div id="space" class="bg-gray-800 w-full flex">
                                <div class="h-60 flex py-7"></div>
                            </div>
                            <!--space -->
                            <!-- Messages_ENDS -->
                        </div>
                        <div class="fixed bottom-10 w-2/5">
                            <div class="flex w-full">
                                <div class="flex-1">
                                    <label class="relative">
                                        <span class="absolute flex left-4 text-gray-400" style="top:3px;"><i class="fas fa-search"></i></span>
                                        <input id="textInput" data-bot="<?php echo $bot->ID; ?>" class="pl-9 py-3 pr-3 border border-gray-400 rounded-full w-full text-gray-800 shadow-md" type="text" name="search" placeholder="Ask your question" />
                                        <span class="hover:text-green-500 cursor-pointer absolute flex right-6 text-gray-400" style="top:3px;"><i class="far fa-paper-plane"></i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--ChatBot_SECTION_END-->

            </div>
        </div>
    </div>
    <!-- Js Scripts -->
    <script src="assets/js/chat.js"></script>
    <!-- Js Link For Code Highlight -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js" integrity="sha512-7Z9J3l1+EYfeaPKcGXu3MS/7T+w19WtKQY/n+xzmw4hZhJ9tyYmcUS+4QqAlzhicE5LAfMQSF3iFTK9bQdTxXg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js" integrity="sha512-SkmBfuA2hqjzEVpmnMt/LINrjop3GKWqsuLSSB3e7iBmYK7JuWw4ldmmxwD9mdm2IRTTi0OxSAfEGvgEi0i2Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>