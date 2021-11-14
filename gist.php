<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/styles/default.min.css">
    <title>My Own Gist</title>
</head>

<body>
    <div id="container">
        <?php
        require "config.php";
        if (!isset($_GET["id"])) {
            die("Not Found");
        }

        if (isset($_GET["delete"])) {
            if (isset($_GET['confirm'])) {
                try {
                    $stmt = $conn->prepare("DELETE FROM Gists WHERE `id` = :id");
                    $stmt->bindParam(':id', $_GET["id"]);
                    $stmt->execute();

                    header("Location: gists.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }

            die("<a href=\"gist.php?delete&id=" . $_GET["id"] . "&confirm=true\">Click to confirm</a><br><br><br><a class=\"btn\" href=\"gist.php?id=" . $_GET["id"] . "\">Click to go back</a>");

            die();
        }

        try {
            $stmt = $conn->prepare("SELECT * FROM Gists WHERE `id` = :id");
            $stmt->bindParam(':id', $_GET["id"]);
            $stmt->execute();

            // set the resulting array to associative
            $result = $stmt->fetchAll();

            if (!isset($result[0]['id'])) {
                die("Not found");
            } else {
                $title = $result[0]['title'];
                $type = $result[0]['type'];
                $code = $result[0]['content'];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
        <h1 class="heading"><?= htmlspecialchars($title) ?> <sup><?= $type ?></sup></h1>
        <pre><code class="language-<?= $type ?>"><?= str_replace("<", "&lt;", $code)  ?></code></pre>
        <br><br>
        <a href="gists.php" class="btn">Show other gists</a>
        <a href="index.php" class="btn">Create Gist</a>
        <a href="gist.php?delete&id=<?= $result[0]['id'] ?>" style="background: #ab0000;" class="btn">Delete</a>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script>
    <script>
        hljs.highlightAll();
    </script>
</body>

</html>