<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "style.php"; ?>
    <?php
    require "db.php";
    $product_id = $_GET['id'];
    $query = "SELECT products.* FROM products WHERE id = {$product_id}";
    $product = $database->query($query)->fetch_assoc();

    ?>

    <title><?php echo $product['name']; ?></title>
</head>

<body>
    <?php require "navigation.php"; ?>
    <?php require "ProductActions.php"; ?>
    <?php
    $query = "SELECT path FROM product_images WHERE product_id = $product_id";
    $images = $database->query($query)->fetch_all();
    ?>
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
    <div class="container mt-5">
        <div id="carouselExampleControls" class="carousel slide bg-dark w-75 d-block mx-auto" data-ride="carousel">
            <div class="carousel-inner">
                <?php $i = 0; ?>
                <?php foreach ($images as $image) : ?>
                    <div class="carousel-item <?php if ($i == 0) echo "active"; ?>">
                        <img src="<?php echo $image[0]; ?>" class="d-block w-100 cimage" alt="...">
                    </div>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon text-dark" aria-hidden="true"></span>
                <span class="sr-only text-dark">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="details mt-4 row">
            <div class="col-md-7">
                <h3 class="text-center"><?php echo $product['name']; ?></h3>
                <h5 class="text-center"><?php echo $product['seller']; ?></h5>
                <div class="review text-center">
                    <?php $rate = ProductActions::getAverageRating($product['id']); ?>
                    <?php for ($i = 0; $i < 5; $i++) {
                        if ($i < $rate) {
                            echo "<i class = 'fa fa-star text-primary'></i>";
                        } else {
                            echo "<i class = 'fa fa-star-o text-primary'></i>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-5 d-flex align-items-center justify-content-center flex-column">
                <h5 class="text-center text-primary"><?php echo number_format($product['price'], 2) . "din"; ?></h5>
                <button class="btn btn-primary">Dodaj u korpu</button>
            </div>
        </div>
        <div class="reviews mt-5">
            <ul class="nav nav-pills" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#description" role="tab" aria-controls="home" aria-selected="true">Opis</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="profile" aria-selected="false">Recenzije proizvoda</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#personal_review" role="tab" aria-controls="contact" aria-selected="false">Licna recenzija</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="home-tab">
                    <p>Opis proizvoda:</p>
                    <span><?php echo $product['description']; ?></span>
                </div>
                <div class="tab-pane fade my-3" id="reviews" role="tabpanel" aria-labelledby="profile-tab">
                    <h6 class="text-center">Pogledajte sta nasi kupci imaju da kazu za dati proizvod kako biste mogli da
                        napravite najbolje informisanu kupovinu.</h6>
                    <div class="container">
                        <?php
                        $query = "SELECT * FROM product_reviews WHERE product_id = $product_id AND username != '{$_SESSION['user']['username']}'";
                        $reviews = $database->query($query);
                        if ($reviews != false) {
                            $reviews = $reviews->fetch_all(MYSQLI_ASSOC);
                        } else {
                            $reviews = [];
                        }
                        ?>
                        <?php if (count($reviews) == 0) : ?>
                            <h6 class="text-center">Trenutno ni jedan korisnik nije ostavio ocenu na ovaj proizvod.</h6>
                        <?php else : ?>
                            <?php foreach ($reviews as $review) : ?>
                                <div class="card border-grey my-3">
                                    <div class="card-header d-flex justify-content-between">
                                        <div>
                                            <?php echo $review['username'] . ": "; ?>
                                            <?php for ($i = 0; $i < 5; $i++) {
                                                if ($i < $review['grade']) {
                                                    echo "<i class = 'fa fa-star text-primary'></i>";
                                                } else {
                                                    echo "<i class = 'fa fa-star-o text-primary'></i>";
                                                }
                                            }
                                            ?>
                                        </div>
                                        <?php echo $review['review_date']; ?>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><?php echo $review['review']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="tab-pane fade container w-50 my-3" id="personal_review" role="tabpanel" aria-labelledby="contact-tab">
                    <?php
                    //First, check if user can review a certain product
                    $can_review = false;
                    $query = "SELECT * FROM product_orders WHERE username = '{$_SESSION['user']['username']}' AND product_id = {$product['id']} AND status = 1";
                    $result = $database->query($query);
                    if ($result != false) {
                        $can_review = true;
                    }
                    ?>
                    <?php if ($can_review) : ?>
                        <?php
                        $query = "SELECT * FROM product_reviews WHERE product_id = {$product['id']} AND username = '{$_SESSION['user']['username']}'";
                        $review = $database->query($query)->fetch_assoc();
                        ?>
                        <?php if ($review == null) : ?>
                            <form action="server.php" method="POST">
                                <div class="form-group">
                                    <label for="grade">Ocena proizvoda(1-5)</label>
                                    <input type="number" min="1" max="5" name="grade" id="grade" class="form-control" placeholder="" aria-describedby="helpId">
                                </div>
                                <div class="form-group">
                                    <label for="review">Recenzija</label>
                                    <textarea type="text" name="review" id="review" class="form-control" placeholder="" aria-describedby="helpId"></textarea>
                                </div>
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="add_review" value="1">
                                <input type="hidden" name="username" value="<?php echo $_SESSION['user']['username']; ?>">
                                <button type="submit" class="btn btn-success btn-block">Oceni proizvod</button>

                            </form>
                        <?php else : ?>
                            <form action="server.php" method="POST">
                                <div class="form-group">
                                    <label for="grade">Ocena proizvoda(1-5)</label>
                                    <input type="number" min="1" max="5" name="grade" id="grade" class="form-control" value="<?php echo $review['grade']; ?>" placeholder="" aria-describedby="helpId">
                                </div>
                                <div class="form-group">
                                    <label for="review">Recenzija</label>
                                    <textarea type="text" name="review" id="review" class="form-control" placeholder="" aria-describedby="helpId"><?php echo $review['review']; ?></textarea>
                                </div>
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="edit_review" value="1">
                                <input type="hidden" name="username" value="<?php echo $_SESSION['user']['username']; ?>">
                                <button type="submit" class="btn btn-danger btn-block">Izmeni ocenu</button>

                            </form>
                        <?php endif; ?>
                    <?php else : ?>
                        <h6 class="text-center">Nemate ni jednu odobrenu porudzbinu za ovaj proizvod. Kreirajte porudzbinu,
                            sacekajte da je prodavac odobri, kako biste bili u mogucnosti ostavljanja ocene na odabrani
                            proizvod.</h6>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        $(function() {
            // $('#myTab a:last-child').tab('show')
        })
    </script>
</body>

</html>