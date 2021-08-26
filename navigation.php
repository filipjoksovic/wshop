<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="pocetna.php">KupiProdaj</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="pocetna.php">Pocetna <span class="sr-only">(current)</span></a>
            </li>
            <?php if ($_SESSION['user']['type'] == "korisnik") : ?>
                <li class="nav-item">
                    <a class="nav-link" href="korpa.php">Korpa (<?php echo count($_SESSION['cart']); ?>) </a>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION['user']['type'] == "prodavac") : ?>
                <a class="nav-link" href="porudzbine.php">Porudzbine </a>

            <?php endif; ?>
            <?php if ($_SESSION['user']['username'] == null) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Uloguj se</a>
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link" href="sessionend.php">Odjavi se</a>
                </li>
            <?php endif; ?>
        </ul>
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Pronadji proizvod" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Pretrazi</button>
        </form>
    </div>
</nav>