<?php
require "config.php";
$e = $m = "";
if (isset($_GET['create']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['type'])) {
    if (empty($_POST['title']) or empty($_POST['content']) or empty($_POST['type'])) {
        $e = true;
        $m = "Please fill all the fields";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO gists (`title`, `content`, `type`, `id`)
            VALUES (:title, :content, :type, :id)");

            $stmt->bindParam(':title', $tit);
            $stmt->bindParam(':content', $cont);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':id', $id);

            switch ($_POST['type']) {
                case "1":
                    $type = "";
                    break;
                case "2":
                    $type = "css";
                    break;
                case "3":
                    $type = "javascript";
                    break;
                case "4":
                    $type = "php";
                    break;
                case "5":
                    $type = "xml";
                    break;
                case "6":
                    $type = "jsx";
                    break;
                case "7":
                    $type = "c#";
                    break;
                default:
                    $type = "";
            }

            $tit = $_POST['title'];
            $cont = $_POST['content'];
            $type = $type;
            $id = generateRandomString(10);
            $stmt->execute();

            $e = false;
            $m = "Gist added";

            header("Location: gist.php?id=".$id);
        } catch (PDOException $er) {
            $e = true;
            $m = $er->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>My Own Gist</title>
</head>

<body>
    <div id="container">
        <?php if (defined("ERROR")) {
            die("An error occured");
        } ?>
        <?php
        if ($e) {
            echo "<div class=\"message error\">" . $m . "</div>";
        }
        ?>
        <h1 class="heading">Add new Gist</h1>
        <!---- ---->
        <div class="divider"></div>
        <!---- ---->
        <form action="?create" id="newgist" method="POST">
            <!---- ---->
            <label for="gist-title" class="label">Title</label>
            <input type="text" id="gist-title" name="title" class="input">
            <!---- ---->
            <label for="gist-content" class="label">Content</label>
            <textarea id="gist-content" name="content" class="input" style="height: 200px;font-family: monospace;font-size: 15px;"></textarea>
            <!---- ---->
            <label for="gist-type" class="label">Type</label>
            <select name="type" id="gist-type" class="input">
                <option value="1">Plain text</option>
                <option value="2">CSS</option>
                <option value="3">Javascript</option>
                <option value="4">PHP</option>
                <option value="5">HTML</option>
                <option value="6">JSX</option>
                <option value="7">C#</option>
            </select>
            <!---- ---->
            <div class="divider"></div>
            <!---- ---->
            <button type="submit" class="btn">Create Gist</button>
        </form>
        <!---- ---->
        <div class="divider"></div>
        <div class="divider"></div>
        <div class="divider"></div>
        <!---- ---->
        <a href="gists.php" class="btn">Show other gists</a>
    </div>
</body>

</html>