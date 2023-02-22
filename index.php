<?php
session_start();
include('header.php');
include('Articol.php');
?>

    <div class="container">
        <h1>Revista</h1>
        <div class="categories">
            <h3>Categorii</h3>
            <a href="categorie.php?categorie=artistic">Artistic</a>
            <a href="categorie.php?categorie=tehnic">Tehnic</a>
            <a href="categorie.php?categorie=stiintific">Stiintific</a>
            <a href="categorie.php?categorie=moda">Moda</a>
            <br>
        </div>
        <?php
        // verifica daca utilizatorul este logat
        if (isset($_SESSION['utilizator'])) {
            // dacă utilizatorul este logat, afișează numele utilizatorului și butonul Logout
            echo '<h3>Bun venit, ' . $_SESSION['utilizator'] . '!</h3>';
            echo '<a href="logout.php" class="btn btn-primary">Logout</a>';

            //if ($_SESSION['utilizator']->getTipUtilizator() == 'autor') {
            //    echo '<a href="adaugaArticol.php" class="btn btn-primary">Adaugă articol</a>';
            //}
        } else {
            // dacă utilizatorul nu este logat, afișează butoanele Login și Sign up
            echo '<a href="login.php" class="btn btn-primary">Login</a>';
            echo '<a href="signup.php" class="btn btn-success">Sign up</a>';
        }

        //var_dump($_SESSION['utilizator']);
        ?>
    </div>

<?php
include('footer.php');
?>