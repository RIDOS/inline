<?php
require_once("../private/mysql/connect.php");
$obj = new DataBase();

$ifSearch = false;
$text = "";
if (isset($_POST["text"]))
{
    if (strlen($_POST["text"]) > 2)
    {
        $ifSearch = true;
        $posts = $obj->search($_POST["text"]);
        $text = $_POST["text"];
    }
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--  google  -->
    <meta name="googlebot" content="notranslate" />

    <title>Inline</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <form method="post" class="search">
            <h2>Search...</h2>
            <label for="text_id"></label><input type="text" name="text" id="text_id">
            <input type="submit" value="go">
        </form>
    </header>
    <main>
        <!-- Posts -->
        <?php
        if (!$ifSearch)
            $posts = $obj->select_posts();
        while ($row = mysqli_fetch_assoc($posts))
        {
        ?>
        <div class="posts">
            <h3><?php echo $row['title']; ?></h3>
            <p><?php echo $row['body']; ?></p>
            <!-- Commentaries -->
            <?php

            $comments = $obj->select_comments($row['id']);

            while ($Row = mysqli_fetch_assoc($comments))
            {
                if ($ifSearch)
                {
                    if (strpos($Row['body'], $text)) {
                        ?>
                        <div class="comment">
                            <h3><?php echo $Row['name']; ?></h3>
                            <h3><?php echo $Row['email']; ?></h3>
                            <p><?php echo $Row['body']; ?></p>
                        </div>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <div class="comment">
                        <h3><?php echo $Row['name']; ?></h3>
                        <h3><?php echo $Row['email']; ?></h3>
                        <p><?php echo $Row['body']; ?></p>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
        }
        ?>
    </main>
</body>
</html>