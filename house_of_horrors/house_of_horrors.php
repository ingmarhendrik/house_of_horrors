<?php
require('conf.php');

// Adding user and saving the first name to the database
if(isset($_REQUEST["first_name"])) {
    global $connection;
    $request=$connection->prepare("INSERT INTO house_of_horrors(first_name) VALUES (?)");
    $request->bind_param("s", $_REQUEST["first_name"]);
    $request->execute();

    header("Location: ".$_SERVER['PHP_SELF']);

    exit();
}

// Deleting user
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
    <div class="buy-ticket-form">
        <h2>Osta pilet</h2>
        <form action="?" method="post">
            <input type="text" name="first_name" placeholder="Eesnimi">
            <input type="submit" value="Osta pilet">
        </form>
    </div>
</main>

</body>
</html>