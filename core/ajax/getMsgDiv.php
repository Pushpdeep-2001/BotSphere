<?php
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['type'])) {
        $type = $_GET['type'];

        if (!empty($type)) {
            if ($type === "User") {
                $message = [
                    'html' => '<div class="message w-full flex justify-center">
                                        <div class="w-1/2 h-full flex py-7">
                                            <div class="flex items-start h-full mr-5 ">
                                                <div class="w-8 h-8 overflow-hidden border border-blue-500 rounded">
                                                    <img src="assets/images/avatar.png" />
                                                </div>
                                            </div>
                                            <div id="text" class="text-white flex-1">
                                                [message]
                                            </div>
                                            <div></div>
                                        </div>
                                    </div>'
                ];

            }elseif($type === "AI"){
                $message = [
                    'html' => '<!--BOT_CHAT-->
                                    <div class="message bg-gray-800 w-full flex justify-center">
                                        <div class="w-1/2 h-full flex py-10">
                                            <div class="flex items-start h-full mr-5 ">
                                                <div class="w-8 h-8 bg-white overflow-hidden border border-green-500 rounded">
                                                    <img src="assets/images/mygpt.png" />
                                                </div>
                                            </div>
                                            <div id="text" class="text-white text-base flex-1">
                                                [message]
                                            </div>
                                        </div>
                                    </div>
                                    <!--BOT_CHAT_ENDS-->
                                    <div id="space" class="bg-gray-800 w-full flex">
                                <div class="h-60 flex py-7"></div>
                            </div>'
                ];
            }else{
                $message = [
                    'html' => '<!-- ReponseLoader-->
<div id="loader" class="bg-gray-800 w-full flex justify-center">
    <div class="w-1/2 h-full flex py-7">
        <div class="flex items-start h-full mr-5 ">
            <div class="w-10 h-10 bg-white items-center justify-center flex rounded">
                <div class="w-8 h-8 animate-spin flex items-center justify-center text-gray-500 bg-white overflow-hidden rounded-full text-2xl"><i class="fas fa-spinner"></i></div>
            </div>
        </div>
        <div class="text-white text-base flex-1">
            <div class=" p-4  w-full">
            <div class="animate-pulse flex space-x-4">
                <div class="flex-1 space-y-6 py-1">
                <div class="h-2 bg-gray-600 rounded"></div>
                <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-4">
                    <div class="h-2 bg-gray-600 rounded col-span-2"></div>
                    <div class="h-2 bg-gray-600 rounded col-span-1"></div>
                    </div>
                    <div class="h-2 bg-gray-600 rounded"></div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<!--ReponseLoader-->
<div id="space" class="bg-gray-800 w-full flex">
    <div class="h-60 flex py-7"></div>
</div>'
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($message);
        }
    }
}
