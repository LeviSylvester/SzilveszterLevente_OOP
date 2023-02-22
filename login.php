<?php
session_start();
require_once 'Utilizator.php';

if (isset($_SESSION['utilizator'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $nume_utilizator = $_POST['nume_utilizator'];
    $parola = $_POST['parola'];
    $utilizator = Utilizator::autentifica($nume_utilizator, $parola);
    if ($utilizator) {
        $_SESSION['utilizator'] = $nume_utilizator;
        header('Location: index.php');
        exit();
    } else {
        $mesaj_eroare = 'Numele de utilizator sau parola sunt incorecte. Te rugăm să încerci din nou.';
    }
}

include 'header.php';
?>

<div class="container">
    <a href='index.php'>Înapoi la pagina principală</a><br><br>
    <h1>Autentificare</h1>
    <?php if (isset($mesaj_eroare)) { ?>
        <div class="alert alert-danger"><?php echo $mesaj_eroare; ?></div>
    <?php } ?>
    <form method="post" action="">
        <div class="form-group">
            <label for="nume_utilizator">Nume utilizator:</label>
            <input type="text" class="form-control" id="nume_utilizator" name="nume_utilizator" required>
        </div>
        <div class="form-group">
            <label for="parola">Parola:</label>
            <input type="password" class="form-control" id="parola" name="parola" required>
        </div>
        <button type="submit" class="btn btn-primary" name="login">Autentifică-te</button>
    </form>
</div>

<?php include 'footer.php'; ?>
