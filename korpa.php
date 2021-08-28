<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Korpa</title>
    <?php require "style.php"; ?>
</head>

<body>
    <?php require "navigation.php"; ?>
    <?php require "db.php"; ?>
    <?php
    $products = [];
    foreach ($_SESSION['cart'] as $key => $in_cart) {
        $query = "SELECT products.*, product_images.path FROM products INNER JOIN product_images where products.id = {$key} AND product_images.product_id = {$key} GROUP BY products.name";
        $product = $database->query($query)->fetch_assoc();
        $product['quantity'] = $in_cart;
        array_push($products, $product);
    }
    ?>
   <?php SessionActions::renderMessages();?>

    <div class="container mt-5">
        <h3 class="text-center">Korpa</h3>
        <?php if (count($products) == 0) : ?>
            <h3 class="text-center">Korpa je prazna. Pogledajte dostupne proizvode na <a href="pocetna.php">pocetnoj</a>
                stranici.</h3>
        <?php else : ?>

            <?php foreach ($products as $product) : ?>
                <div class=" mt-3 mb-4 mb-lg-0">
                    <!-- Card-->
                    <div class="card rounded shadow-sm border-0">
                        <div class="card-body row p-4">
                            <div class="col-md-2">
                                <img src="<?php echo $product['path']; ?>" alt="" class="img-fluid d-block mx-auto mb-3">
                            </div>
                            <div class="col-md-10">
                                <div class="d-flex justify-content-between h-75 flex-column">
                                    <h5> <a href="detalji_proizvoda.php?id=<?php echo $product['id']; ?>" class="text-dark"><?php echo $product['name']; ?></a></h5>
                                    <h6>Kolicina: <?php echo $product['quantity']; ?></h6>
                                    <p class="small text-muted font-italic"><?php echo $product['description']; ?></p>
                                    <h4><?php echo number_format($product['price'], 2) . "din"; ?></h4>

                                </div>
                                <?php if ($_SESSION['user']['username'] == null) : ?>
                                    <a href="detalji_proizvoda.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-block ">Prikazi detalje</a>
                                <?php else : ?>
                                    <a href="remove_from_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-block w-50 mx-auto ">Ukloni iz korpe</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="d-flex w-100 justify-content-around">
                <a href="empty_cart.php" class="mt-5 btn btn-danger btn-lg w-25 mx-auto">Isprazni korpu</a>
                <a href="placanje.php" class="mt-5 btn btn-primary btn-lg w-25 mx-auto">Nastavi na placanje</a>

            </div>

        <?php endif; ?>
    </div>
</body>

</html>