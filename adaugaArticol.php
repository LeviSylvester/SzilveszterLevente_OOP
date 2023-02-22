<?php
// verificam daca formularul a fost trimis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // validam datele introduse de utilizator
    $titlu = filter_input(INPUT_POST, 'titlu', FILTER_SANITIZE_STRING);
    $continut = filter_input(INPUT_POST, 'continut', FILTER_SANITIZE_STRING);
    $categorie = filter_input(INPUT_POST, 'categorie', FILTER_SANITIZE_STRING);

    // verificam daca toate campurile sunt completate
    if (empty($titlu) || empty($continut) || empty($categorie)) {
        $eroare = "Toate câmpurile sunt obligatorii";
    } else {
        // cream un nou articol si il salvam in baza de date
        $utilizator = new Utilizator($_SESSION['id_utilizator']);
        $articol = new Articol();
        $articol->setTitlu($titlu);
        $articol->setContinut($continut);
        $articol->setCategorie($categorie);
        $articol->setIdUtilizator($utilizator->getId());
        $articol->setStatus('neaprobat');
        $articol->salveaza();

        // afisam un mesaj de confirmare
        $mesaj = "Articolul a fost adăugat cu succes. Așteptați aprobarea editorului pentru publicare.";
    }
}
?>

<!-- Formular pentru adaugarea unui articol -->
<form method="POST">
    <div>
        <label for="titlu">Titlu:</label>
        <input type="text" name="titlu" id="titlu" required>
    </div>
    <div>
        <label for="continut">Conținut:</label>
        <textarea name="continut" id="continut" required></textarea>
    </div>
    <div>
        <label for="categorie">Categorie:</label>
        <select name="categorie" id="categorie" required>
            <option value="">-- Alege categorie --</option>
            <?php foreach(Articol::toateCategorii() as $categorie): ?>
                <option value="<?= $categorie ?>"><?= $categorie ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit">Adauga articol</button>
</form>

<?php if(isset($eroare)): ?>
    <p class="eroare"><?= $eroare ?></p>
<?php endif; ?>

<?php if(isset($mesaj)): ?>
    <p class="mesaj"><?= $mesaj ?></p>
<?php endif; ?>
