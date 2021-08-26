<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porudzbine</title>
    <?php require "style.php"; ?>
</head>

<body>
    <?php require "navigation.php"; ?>
    <?php require "db.php"; ?>

    <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>Greska!</strong> <?php echo $_SESSION['error'];
                                        unset($_SESSION["error"]); ?>.
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['message'])) : ?>
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>Uspeh!</strong> <?php echo $_SESSION['message'];
                                    unset($_SESSION["message"]); ?>.
        </div>
    <?php endif; ?>

    <?php
    $query = "SELECT product_orders.*, products.*, product_images.path FROM product_orders INNER JOIN products on products.id = product_orders.product_id INNER JOIN product_images on products.id = product_images.product_id WHERE products.seller = '{$_SESSION['user']['username']}' GROUP BY products.name";
    $orders = $database->query($query)->fetch_all(MYSQLI_ASSOC);
    ?>

    <div class="container mt-5">
        <h3 class="text-center">Pregled porudzbina</h3>
        <?php if (count($orders) == 0) : ?>
            <h5 class="text-center">Nemate dodat ni jedan proizvod.</h5>
        <?php else : ?>
            <div class="table-responsive mt-5">
                <table class="table " id="myTable2">
                    <th onclick="sortTable(0)">Proizvod</th>
                    <th onclick="sortTable(1)">Korisnik</th>
                    <th onclick="sortTable(2)">Ime</th>
                    <th onclick="sortTable(3)">Prezime</th>
                    <th onclick="sortTable(4)">Kolicina</th>
                    <th onclick="sortTable(5)">Odobri porudzbinu</th>
                    <th onclick="sortTable(6)">Odbij porudzbinu</th>
                    <tbody>
                        <?php foreach ($orders as $order) : ?>
                            <!-- <?php var_dump($order); ?> -->
                            <tr>
                                <td class="align-middle"><?php echo $order['name']; ?></td>
                                <td class="align-middle"><?php echo $order['username']; ?></td>
                                <td class="align-middle"><?php echo ucfirst($order['first_name']); ?></td>
                                <td class="align-middle"><?php echo ucfirst($order['last_name']); ?></td>
                                <td class="align-middle"><?php echo ucfirst($order['quantity']); ?></td>
                                <td class="align-middle">
                                    <form action="server.php" method="POST">
                                        <input type="hidden" name="username" value="<?php echo $order['username']; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $order['product_id'] ?>">
                                        <input type="hidden" name="order_date" value="<?php echo $order['order_date'] ?>">
                                        <input type="hidden" name="quantity" value="<?php echo $order['quantity'] ?>">
                                        <input type="hidden" name="allow_order" value="1">
                                        <?php if ($order['quantity'] > $order['stock']) : ?>
                                            <button type="submit" class="btn btn-success btn-block" disabled data-toggle="tooltip" data-placement="top" title="Porucen broj artikala je veci od trenutnog stanja proizvoda">Odobri</button>

                                        <?php else : ?>
                                            <button type="submit" class="btn btn-success btn-block" <?php if ($order['status'] == 1) echo "disabled"; ?>>Odobri</button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                                <td class="align-middle">
                                    <form action="server.php" method="POST">
                                        <input type="hidden" name="username" value="<?php echo $order['username']; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $order['product_id'] ?>">
                                        <input type="hidden" name="order_date" value="<?php echo $order['order_date'] ?>">
                                        <input type="hidden" name="quantity" value="<?php echo $order['quantity'] ?>">
                                        <input type="hidden" name="disable_order" value="1">
                                        <button type="submit" class="btn btn-danger btn-block" <?php if ($order['status'] == -1) echo "disabled"; ?>>Odbij</button>
                                    </form>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <script src="js/porudzbine.js"></script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>

</html>