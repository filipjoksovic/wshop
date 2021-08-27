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
    <?php if ($_SESSION['user']['type'] == "prodavac") : ?>
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
                            <th>Stanje</th>
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
                                        <td class="align-middle"><?php echo $product['stock']; ?></td>
                                        <td class="align-middle"><a href="removeproduct.php?id=<?php echo $product['id']; ?>" class="btn btn-danger">Ukloni proizvod</a></td>
                                        <td class="align-middle"><a href="editproduct.php?id=<?php echo $product['id']; ?>" class="btn btn-warning">Izmeni proizvod</a></td>
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
                        <label for="description">Opis proizvoda</label>
                        <textarea type="text" name="description" id="description" class="form-control" placeholder="" aria-describedby="helpId"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Kategorija proizvoda</label>
                        <select class="form-control" name="cat" id="exampleFormControlSelect1">
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category[0]; ?>"><?php echo ucfirst($category[0]); ?></option>
                            <?php endforeach; ?>
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
                    <div class="form-group">
                        <label for="stock">Stanje u inventaru</label>
                        <input type="text" class="form-control" id="stock" name="stock">
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
        <div class="container mt-5">
            <h3 class="text-center">Pregled i izmena korisnika</h3>
            <?php
            require "db.php";
            $query = "SELECT * FROM users WHERE username != 'admin'";
            $users = $database->query($query)->fetch_all(MYSQLI_ASSOC);
            ?>
            <div class="row">
                <?php foreach ($users as $user) : ?>
                    <div class="col-md-6 my-2">
                        <div class="card">
                            <div class="card-header">
                                <?php echo $user['username']; ?>
                            </div>
                            <div class="card-body">
                                <form action="server.php" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="first_name">Ime</label>
                                                <input type="text" name="fname" id="first_name" class="form-control" placeholder="" aria-describedby="helpId" value="<?php echo $user['first_name']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Prezime</label>
                                                <input type="text" name="lname" id="last_name" class="form-control" placeholder="" aria-describedby="helpId" value="<?php echo $user['last_name']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control" placeholder="" aria-describedby="helpId" value="<?php echo $user['email']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="type">Uloga</label>
                                                <select name="type" id="type" class="form-control">
                                                    <option value="kupac">Kupac</option>
                                                    <option value="prodavac">Kupac</option>
                                                    <option value="admin">Admin (ne preporucujemo)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="edit_user">
                                        <input type="hidden" name="username" value="<?php echo $user['username']; ?>">
                                        <input type="hidden" name="prev_email" value="<?php echo $user['username']; ?>">

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form action="server.php">
                                                <input type="hidden" name="username" value="<?php echo $user['username']; ?>">
                                                <button class="btn btn-danger btn-block" type="submit">Ukloni korisnika</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-warning btn-block" type="submit">Izmeni korisnika</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else : ?>

        <?php require "db.php"; ?>
        <h3 class="text-center">Gost/kupac pocetna</h3>
        <?php
        $query = "SELECT products.*, product_images.path from products INNER JOIN product_images on product_images.product_id = products.id GROUP BY products.name";
        $products = $database->query($query)->fetch_all(MYSQLI_ASSOC);
        ?>
        <div class="container">
            <div class="pb-5 mb-4 row">
                <?php foreach ($products as $product) : ?>
                    <div class="col-md-6 mt-3 mb-4 mb-lg-0 d-flex flex-grow-1">
                        <!-- Card-->
                        <div class="card rounded shadow-sm border-0">
                            <div class="card-body row p-4">
                                <div class="col-md-6 d-flex align-center justify-content-center">
                                    <img src="<?php echo $product['path']; ?>" alt="" class="img-fluid d-block m-auto mb-3">
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between h-75 flex-column">
                                        <h5> <a href="detalji_proizvoda.php?id=<?php echo $product['id']; ?>" class="text-dark"><?php echo $product['name']; ?></a></h5>
                                        <small>Oglas postavio: <?php echo $product['seller']; ?></small>
                                        <p class="small text-muted font-italic"><?php echo $product['description']; ?></p>
                                        <h4><?php echo number_format($product['price'], 2) . "din"; ?></h4>
                                        <ul class="list-inline small">
                                            <li class="list-inline-item m-0"><i class="fa fa-star text-primary"></i></li>
                                            <li class="list-inline-item m-0"><i class="fa fa-star text-primary"></i></li>
                                            <li class="list-inline-item m-0"><i class="fa fa-star text-primary"></i></li>
                                            <li class="list-inline-item m-0"><i class="fa fa-star text-primary"></i></li>
                                            <li class="list-inline-item m-0"><i class="fa fa-star-o text-primary"></i></li>
                                        </ul>
                                        <?php if ($_SESSION['user']['username'] == null) : ?>
                                            <a href="detalji_proizvoda.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-block ">Prikazi detalje</a>
                                        <?php else : ?>
                                            <?php if ($product['stock'] > 0) : ?>
                                                <a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-block ">Dodaj u korpu</a>
                                            <?php else : ?>
                                                <button disabled="disabled" class="btn btn-danger btn-block">Nema na stanju</button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</body>

</html>