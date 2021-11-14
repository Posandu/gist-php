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
        <h1 class="heading">Gists</h1>
        <!---- ---->
        <?php
        require "config.php";

        $conn = new mysqli($servername, $username, $password, $database);

        $sql = "SELECT title,id,type FROM gists";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
             while ($row = $result->fetch_assoc()) {
                echo "<h2><a href=\"gist.php?id=".$row["id"]."\">" .htmlspecialchars( $row["title"]) . "<b><i> ".$row["type"]."</i></b></a></h1>";
            }
            
        } else {
            echo "No Gists";
        }
        $conn->close();
        ?>
        <br><br>
        <a href="index.php" class="btn">Create Gist</a>
    </div>
</body>

</html>