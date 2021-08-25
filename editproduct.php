<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izmeni proizvod</title>
    <?php require "style.php"; ?>
</head>

<body>
    <?php require "navigation.php"; ?>
    <?php
    require "db.php";

    $product_id = $_GET['id'];
    $query = "SELECT * from products WHERE id = {$product_id}";
    $product = $database->query($query)->fetch_array();
    $query = "SELECT DISTINCT category from products";
    $categories = $database->query($query)->fetch_all();
    ?>
    <div class="container mt-5">
        <h3 class="text-center">Izmena proizvoda</h3>
        <form action="server.php" method="post">
            <div class="form-group">
                <label for="product_name">Naziv proizvoda</label>
                <input type="text" name="pname" id="product_name" class="form-control" placeholder="" value="<?php echo $product[1]; ?>">
            </div>
            <div class="form-group">
                <label for="description">Opis proizvoda</label>
                <textarea type="text" name="description" id="description" class="form-control" placeholder="" aria-describedby="helpId"></textarea>
            </div>
            <div class="form-group">
                <label for="product_price">Cena proizvoda</label>
                <input type="text" name="price" id="product_price" class="form-control" placeholder="" value="<?php echo $product[2]; ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Kategorija proizvoda</label>
                <select class="form-control" name="cat" id="exampleFormControlSelect1">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category[0]; ?>" <?php if (strcasecmp($category[0], $product[3]) == 0) : ?>selected<?php endif; ?>><?php echo ucfirst($category[0]); ?></option>
                    <?php endforeach; ?>
                    <option value=-1>Samostalan unos kategorije</option>
                </select>
            </div>
            <div class="form-group" id="catManual">
                <label for="productName">Kategorija proizvoda</label>
                <input type="text" class="form-control" id="productName" name="catManual">
            </div>
            <input type="hidden" name="edit_product" value="1">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <button type="submit" class="btn btn-primary btn-block">Izmeni proizvod</button>
        </form>
    </div>
</body>

</html>