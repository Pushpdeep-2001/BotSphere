<?php
class DB
{
    private $host = 'localhost';
    private $port = '3309'; // Specify the custom port number
    private $dbname = 'mychatgpt';
    private $username = 'root';
    private $password = '';

    public function connect()
    {
        try {
            $db = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->dbname", $this->username, $this->password);

            // Set PDO to throw exceptions on error
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $db;
        } catch (PDOException $error) {
            // Handle the error more gracefully, log or display an error message
            echo 'Connection Error: ' . $error->getMessage();
            return null; // Return null or throw an exception based on your error handling strategy
        }
    }
}
