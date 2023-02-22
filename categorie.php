<?php
require_once 'header.php';
require_once 'Articol.php';
?>

    <div class="container">
        <a href='index.php'>Înapoi la pagina principală</a><br><br>

        <?php
        // verifica daca categoria este setata
        if (isset($_GET['categorie'])) {
            $categorie = $_GET['categorie'];

            // obtine toate articolele din categoria specificata
            $articole = Articol::toateDinCategorie($categorie);

            // afiseaza toate articolele din categoria specificata
            foreach ($articole as $articol) {
                echo "<div class='article'>";
                echo "<h2>" . $articol->getTitlu() . "</h2>";
                echo "<p>Autor: " . $articol->getUtilizator()->getNume() . "</p>";
                echo "<p>Data publicării: " . $articol->getDataPublicarii() . "</p>";
                //echo "<a href='articol.php?id=" . $articol->getId() . "'>Citește mai mult</a>";
                echo "<a href='continut.php?id=" . $articol->getId() . "'>Citește mai mult</a>";
                echo "</div>";
            }
        } else {
            echo "Categoria nu a fost specificată.";
        }
        ?>

    </div>

<?php
require_once 'footer.php';
?>