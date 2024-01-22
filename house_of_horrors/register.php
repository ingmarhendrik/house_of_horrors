<?php
require('conf.php');

// Activating the ticket
if (isset($_POST['entered']) && isset($_REQUEST['user_id'])) {
    global $connection;

    // Updating the existing database record
    $request = $connection->prepare("UPDATE house_of_horrors SET entered = CURRENT_TIMESTAMP WHERE id = ?");
    $request->bind_param("i", $_REQUEST["user_id"]);
    $request->execute();

    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Deactivating the ticket
if (isset($_POST['exited']) && isset($_REQUEST['user_id'])) {
    global $connection;

    // Updating the existing database record
    $request = $connection->prepare("UPDATE house_of_horrors SET exited = CURRENT_TIMESTAMP WHERE id = ?");
    $request->bind_param("i", $_REQUEST["user_id"]);
    $request->execute();

    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>


<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="scripts.js"></script>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Õuduste Maja</title>
</head>
<body>
<header class="header-area overlay">
    <nav class="navbar navbar-expand-md navbar-dark">
        <div class="container">
            <a href="house_of_horrors.php" class="navbar-brand">Õuduste maja haldusrakendus</a>


            <div id="main-nav" class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li><a href="house_of_horrors.php" class="nav-item nav-link active">Osta pilet</a></li>
                    <li><a href="register.php" class="nav-item nav-link">Pileti haldamine</a></li>
                    <li><a href="list_of_currents.php" class="nav-item nav-link">Hetke sisenemised</a></li>
                </ul>
            </div>
        </div>
    </nav>

</header>

<main>
    <div class="users-list">
        <div class="users-title">
            <h2>Kõik külastajad</h2>
        </div>
        <?php
        global $connection;
        // Show data from the database
        $request = $connection->prepare("SELECT id, first_name, entered, exited FROM house_of_horrors");
        $request->bind_result($id, $first_name, $entered, $exited);
        $request->execute();
        $sorted_names = array();

        $usersArray = array();
        while($request->fetch()) {
            $usersArray[] = array('id' => $id, 'first_name' => $first_name, 'entered' => $entered, 'exited' => $exited);
        }



        foreach ($usersArray as $user) {
            $status = "";
            $text_color = "";


            if (!empty($user['exited'])) {
                $status = "Väljunud";
                $text_color = "text-danger";
            } elseif (!empty($user['entered'])) {
                $status = "Sisenenud";
                $text_color = "text-success";
            } else {
                $status = "Ei ole sisenenud";
                $text_color = "text-muted";
            }

            echo "<a href='?user_id={$user['id']}'>$user[first_name] - <span class='$text_color'> $status</span></a><br>";
        }
        ?>
    </div>
    <div class="user-information">
        <?php
        global $connection;
        if(isset($_REQUEST["user_id"])) {
            $request = $connection->prepare("SELECT id, first_name, entered, exited FROM house_of_horrors WHERE id=?");
            $request->bind_result($id, $first_name, $entered, $exited);
            $request->bind_param("i", $_REQUEST["user_id"]);
            $request->execute();
            // Näitame ühekaupa.

            if ($request->fetch()) {
                echo "<h2>$id</h2>";
                echo "<span>Eesnimi: ". $first_name."</span>";
                echo "<br>";
                echo "<span>Sisenemine: ". $entered."</span>";
                echo "<br>";
                echo "<span>Väljumine: ". $exited."</span>";
                ?>
                <form action="" method="POST">
                    <button name="entered">Sisenemine</button>
                    <input type="hidden" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
                </form>

                <form action="" method="POST">
                    <button name="exited">Väljumine</button>
                    <input type="hidden" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
                </form>
                <?php
            }
        }
        ?>
    </div>
</main>
