<?php
session_start();
require_once 'header.php';
require_once 'Articol.php';
require_once 'Utilizator.php';
?>

<div class="container">
    <a href='index.php'>Înapoi la pagina principală</a><br><br>
    <?php
    if (isset($_GET['id'])) {
        $id_articol = $_GET['id'];
        $articol = Articol::gasesteDupaId($id_articol);
        if ($articol) {
            $titlu = $articol->getTitlu();
            $continut = $articol->getContinut();
            $utilizator = $articol->getUtilizator()->getNume();
            $data_publicarii = $articol->getDataPublicarii();

            if (isset($_SESSION['utilizator'])) {
                // utilizatorul este autentificat, afiseaza continutul articolului
                echo "<h2>$titlu</h2>";
                echo "<p>Autor: $utilizator</p>";
                echo "<p>Data publicării: $data_publicarii</p>";
                echo "<p>$continut</p>";
            } else {
                // utilizatorul nu este autentificat, afiseaza butoanele Login si Sign up
                echo "<h2>$titlu</h2>";
                echo "<p>Autor: $utilizator</p>";
                echo "<p>Data publicării: $data_publicarii</p>";
                echo "<p>Pentru a citi întregul articol, trebuie să fiți autentificat.</p>";
                echo "<a href='login.php' class='btn btn-primary'>Login</a>";
                echo "<a href='signup.php' class='btn btn-success'>Sign up</a>";
            }
        } else {
            echo "Articolul nu a fost găsit.";
        }
    } else {
        echo "Articolul nu a fost specificat.";
    }
    ?>
</div>

<?php require_once 'footer.php'; ?>
