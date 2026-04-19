<?php
include '../computer/db.php';

// Récupérer tous les produits
$produits = $conn->query("SELECT * FROM produits");
$criteres = $conn->query("SELECT * FROM criteres");

// Créer un mapping critere -> colonne dans produits
$crit_map = [];
while ($c = $criteres->fetch_assoc()) {
    $crit_map[$c['id']] = strtolower(str_replace(' ', '_', $c['nom'])); // ex: RAM -> ram
}

while ($p = $produits->fetch_assoc()) {
    foreach ($crit_map as $crit_id => $colonne) {
        $valeur = $p[$colonne] ?? '';
        // Vérifie que la ligne n'existe pas déjà
        $check = $conn->query("SELECT * FROM valeurs_critere WHERE produit_id={$p['id']} AND critere_id=$crit_id");
        if ($check->num_rows == 0) {
            $conn->query("INSERT INTO valeurs_critere (produit_id, critere_id, valeur) VALUES ({$p['id']}, $crit_id, '".addslashes($valeur)."')");
        }
    }
}

echo "Valeurs de critère insérées avec succès!";