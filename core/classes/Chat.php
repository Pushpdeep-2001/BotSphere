<?php
class Chat
{
    public $db;

    function __construct()
    {
        $db = new DB;
        $this->db = $db->connect();
    }


    public function getChatBots()
    {
        $stmt = $this->db->prepare("SELECT * FROM `bots`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getBot($botID)
    {
        $stmt = $this->db->prepare("SELECT * FROM `bots` WHERE `ID` = :botID");
        $stmt->bindParam(":botID", $botID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getChat($botID)
    {
        $stmt = $this->db->prepare("SELECT * FROM `chat` WHERE `botID` = :botID");
        $stmt->bindParam(":botID", $botID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function storeMessages($message, $type, $botID)
    {
        $stmt = $this->db->prepare("INSERT INTO `chat` (`text`,`author`,`botID`) VALUES (:msg, :author, :botID) ");
        $stmt->bindParam("msg", $message, PDO::PARAM_STR);
        $stmt->bindParam("author", $type, PDO::PARAM_STR);
        $stmt->bindParam(":botID", $botID, PDO::PARAM_INT);
        $stmt->execute();
    }


    public function getCodes($text)
    {
        $regex    = '/```([\s\S]*?)\n([\s\S]*?)\n```/';
        $text     = preg_replace_callback($regex, function($matches) {
            $language = $matches[1];
            $code     = $matches[2];
            $class    = ((!empty($language) ? 'language-' .$language: 'language.php' ));

            return '<pre><code class="'.$class.'">'.$code.'</code></pre>';
        }, $text);
        return $text;
    }

    public function getRecentChat()
    {
        $sql = "SELECT c.botID, b.name as botName, c.text
                    FROM chat c JOIN bots b ON c.botID = b.ID
                        WHERE (c.botID, c.ID) 
                        IN(SELECT botID, MAX(ID) FROM chat GROUP BY botID)";

        $stmt = $this->db->query($sql);
        $messages = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($messages as $message) {
            echo '<!-- RECENT-MESSAGE -->
<a href="chat.php?bot=' . $message->botID . '">
    <li class="menu-list my-1 hover:bg-gray-800 rounded cursor-pointer">
        <div class="flex text-white items-center">
            <div class="text-white px-3 py-4 text-2xl"><i class="fas fa-robot"></i></i></div>
            <div class="flex-1 relative flex items-center justify-space-between">
                <div class="flex-col flex">
                    <span style="font-size: 20px;" class="font-bold">' . $message->botName . '</span>
                    <span style="font-size: 20px;" class="truncate flex-2 overflow-hidden w-4/5 text-sm">
                    ' . ((strlen($message->text)>40) ? substr($message->text, 0, 40) : $message->text). '</span>
                </div>
            </div>
        </div>
    </li>
</a>
<!-- RECENT-MESSAGE_ENDS-->';
        }
    }
}
