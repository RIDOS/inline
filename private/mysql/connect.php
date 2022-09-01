<?php
// Connect to SQL.
class DataBase
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "inline_db";
    public $dbConn;

    function __construct()
    {
        $this->dbConn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
    }

    function __destruct()
    {
        @mysqli_close($this->dbConn);
    }

    public function search($text)
    {
        $myQuery = "SELECT posts.id as id, posts.title as title, posts.body as body 
                    FROM `posts` 
                    INNER JOIN comments ON comments.postId = posts.id 
                    WHERE comments.body LIKE '%$text%'";
        return mysqli_query($this->dbConn, $myQuery);
    }

    public function select_posts()
    {
        $myQuery = "SELECT * FROM posts;";
        return mysqli_query($this->dbConn, $myQuery);
    }

    public function select_comments($id)
    {
        $myQuery = "SELECT * FROM comments WHERE postId = '$id';";
        return mysqli_query($this->dbConn, $myQuery);
    }

    public function insert_posts($id, $user_id, $title, $body)
    {
        $myQuery = "INSERT IGNORE INTO `posts`(`id`, `user_id`, `title`, `body`) 
                        VALUES ('$id','$user_id','$title','$body')";
        return @mysqli_query($this->dbConn, $myQuery);
    }

    public function insert_comments($id, $postId, $name, $email, $body)
    {
        $myQuery = "INSERT IGNORE INTO `comments`(`id`, `postId`, `name`, `email`, `body`) 
                        VALUES ('$id','$postId','$name','$email','$body')";
        return @mysqli_query($this->dbConn, $myQuery);
    }
}