<!DOCTYPE html>
<html>
<head>
    <title><?php echo $service['name']; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main class="container mt-4">
        <h1><?php echo $service['name']; ?></h1>
        <p><?php echo $service['description']; ?></p>
        <p>Fiyat: <?php echo $service['price']; ?></p>

        <form action="index.php?action=buy" method="post">
            <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
            <button type="submit" class="btn btn-primary">Satın Al</button>
        </form>
    </main>

    </body>
</html>