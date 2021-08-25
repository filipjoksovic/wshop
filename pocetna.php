<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naslovna</title>
    <?php include("style.php"); ?>
</head>

<body>
    <?php include("navigation.php"); ?>
    <!-- <?php var_dump($_SESSION); ?> -->
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
    <?php if ($_SESSION['user']['type'] == "kupac") : ?>
        <h3>Kupac pocetna</h3>
    <?php elseif ($_SESSION['user']['type'] == "prodavac") : ?>
        <?php
        require "db.php";
        $query = "SELECT products.*, product_images.path FROM products INNER JOIN product_images on products.id = product_images.product_id WHERE seller = '{$_SESSION['user']['username']}' GROUP BY products.name";
        $products = $database->query($query)->fetch_all(MYSQLI_ASSOC);
        $query = "SELECT DISTINCT category from products";
        $categories = $database->query($query)->fetch_all();
        ?>
        <div class="p-5 container-fluid row">
            <div class="col-md-9">
                <h3 class="text-center">
                    Pregled Vasih proizvoda
                </h3>
                <?php if (count($products) == 0) : ?>
                    <h5 class="text-center">Nemate dodat ni jedan proizvod.</h5>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table ">
                            <th>Slika</th>
                            <th>Sifra</th>
                            <th>Naziv</th>
                            <th>Kategorija</th>
                            <th>Cena</th>
                            <th>Obrisi proizvod</th>
                            <th>Izmeni proizvod</th>
                            <tbody>
                                <?php foreach ($products as $product) : ?>
                                    <!-- <?php var_dump($product); ?> -->
                                    <tr>
                                        <td><img src="<?php echo $product['path']; ?>" class="img-thumbnail pimg"></td>
                                        <td class="align-middle"><?php echo $product['id']; ?></td>
                                        <td class="align-middle"><?php echo $product['name']; ?></td>
                                        <td class="align-middle"><?php echo ucfirst($product['category']); ?></td>
                                        
                                        <td class="align-middle"><?php echo $product['price']; ?></td>
                                        <td class="align-middle"><a href = "removeproduct.php?id=<?php echo $product['id'];?>" class="btn btn-danger">Ukloni proizvod</a></td>
                                        <td class="align-middle"><a href = "editproduct.php?id=<?php echo $product['id'];?>" class="btn btn-warning">Izmeni proizvod</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-3">
                <h3 class="text-center">Dodaj proizvod</h3>
                <form method="POST" action="server.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="productName">Naziv proizvoda</label>
                        <input type="text" class="form-control" id="productName" name="pname">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Kategorija proizvoda</label>
                        <select class="form-control" name="cat" id="exampleFormControlSelect1">
                            <?php foreach($categories as $category):?>
                                <option value = "<?php echo $category[0];?>"><?php echo ucfirst($category[0]);?></option>
                                <?php endforeach;?>
                                <option value=-1>Samostalan unos kategorije</option>
                            </select>
                    </div>
                    <div class="form-group" id="catManual">
                        <label for="productName">Kategorija proizvoda</label>
                        <input type="text" class="form-control" id="productName" name="catManual">
                    </div>
                    <div class="form-group">
                        <label for="productPrice">Cena proizvoda</label>
                        <input type="text" class="form-control" id="productPrice" name="price">
                    </div>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" name="images[]" class="custom-file-input" id="inputGroupFile01" multiple>
                            <label class="custom-file-label" for="inputGroupFile01">Odaberite slike</label>
                        </div>
                    </div>
                    <input type="hidden" name="username" value="<?php echo $_SESSION['user']['username']; ?>">
                    <input type="hidden" name="add_product" value="1">
                    <button type="submit" class="btn btn-primary btn-block">Dodaj proizvod</button>
                </form>
            </div>

        </div>
    <?php elseif ($_SESSION['user']['type'] == "admin") : ?>
        <h3>Admin pocetna</h3>

    <?php else : ?>
        <h3>Gost pocetna</h3>
    <?php endif; ?>
</body>

</html>