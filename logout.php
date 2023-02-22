<?php
session_start();

if (isset($_SESSION['utilizator'])) {
// distrugem sesiunea curenta
    session_destroy();

// redirecționăm utilizatorul către pagina principală
    header('Location: index.php');
    exit();
} else {
// dacă utilizatorul nu este logat, afișăm un mesaj de eroare
    $mesaj_eroare = 'Nu poți face logout deoarece nu ești autentificat.';
}