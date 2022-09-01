<?php
require_once("../../private/mysql/connect.php");

try {
$posts_and_comments = new DataBase();
$count_post = $count_comments = 0;

// Get API and create array.
$urlP = "https://jsonplaceholder.typicode.com/posts";
$urlC = "https://jsonplaceholder.typicode.com/comments";

$dataP = json_decode(file_get_contents($urlP));
$dataC = json_decode(file_get_contents($urlC));

    foreach ($dataP as $tmp) {
        if ($posts_and_comments->insert_posts($tmp->id, $tmp->userId, $tmp->title, $tmp->body))
            $count_post++;
    }

    foreach ($dataC as $tmp) {
        if ($posts_and_comments->insert_comments($tmp->id, $tmp->postId, $tmp->name, $tmp->email, $tmp->body))
            $count_comments++;
    }

    echo "Загружено '$count_post' записей и '$count_comments' комментариев";
}
catch (ErrorException $ex)
{
    echo "Ошибка! " . $ex;
}