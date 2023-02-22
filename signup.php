<?php
session_start()
?>

<div class="container">
    <a href='index.php'>Înapoi la pagina principală</a><br><br>

    <h1>Înregistrare</h1>
    <form method="post" action="">
        <div class="form-group">
            <label for="nume_utilizator">Nume utilizator:</label>
            <input type="text" class="form-control" id="nume_utilizator" name="nume_utilizator" required>
        </div>
        <div class="form-group">
            <label for="parola">Parola:</label>
            <input type="password" class="form-control" id="parola" name="parola" required>
        </div>
        <div class="form-group">
            <label for="tip_utilizator">Tip utilizator:</label>
            <select class="form-control" id="tip_utilizator" name="tip_utilizator">
                <option value="cititor">Cititor</option>
                <option value="autor">Autor</option>
                <option value="editor">Editor</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Înregistrează-te</button>
    </form>
</div>
<?php
require_once 'Utilizator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilizator = new Utilizator();
    $utilizator->setNumeUtilizator($_POST['nume_utilizator']);
    $utilizator->setParola($_POST['parola']);
    $utilizator->setTipUtilizator($_POST['tip_utilizator']);
    $utilizator->salveaza();
    header('Location: index.php');
}