<?php

require_once 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

try {
    $parser = new Parser();
    $pdf = $parser->parseFile('storage/app/public/Mega facture - I7433DWW6Q.pdf');
    
    $text = $pdf->getText();
    
    echo "=== ANALYSE DE LA FACTURE PDF ===\n\n";
    echo "Contenu extrait :\n";
    echo "==================\n";
    echo $text;
    
    // Sauvegarder le texte extrait pour analyse
    file_put_contents('facture_texte.txt', $text);
    
    echo "\n\n=== ANALYSE TERMINÉE ===\n";
    echo "Le texte a été sauvegardé dans 'facture_texte.txt'\n";
    
} catch (Exception $e) {
    echo "Erreur lors de l'analyse du PDF : " . $e->getMessage() . "\n";
} 