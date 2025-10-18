<?php

/**
 * Script de test pour vérifier les images et simuler l'upload
 */
$dir = __DIR__.'/public/zbinvestments/';
$files = scandir($dir);
$validImages = [];

echo "=== Analyse des images dans public/zbinvestments/ ===\n\n";

foreach ($files as $file) {
    if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file)) {
        $path = $dir.$file;
        $info = @getimagesize($path);

        if ($info) {
            $size = filesize($path);
            $isValid = ($info[0] >= 800 && $info[1] >= 600 && $size <= 10 * 1024 * 1024);

            echo ($isValid ? '✓' : '✗').' '.$file."\n";
            echo "   Dimensions: {$info[0]}x{$info[1]}\n";
            echo '   Taille: '.round($size / 1024 / 1024, 2)." MB\n";
            echo '   Type: '.$info['mime']."\n";

            if (! $isValid) {
                if ($info[0] < 800 || $info[1] < 600) {
                    echo "   ⚠️  Image trop petite (min 800x600)\n";
                }
                if ($size > 10 * 1024 * 1024) {
                    echo "   ⚠️  Image trop lourde (max 10 MB)\n";
                }
            }

            echo "\n";

            if ($isValid) {
                $validImages[] = [
                    'path' => $path,
                    'name' => $file,
                    'width' => $info[0],
                    'height' => $info[1],
                    'size' => $size,
                ];
            }
        }
    }
}

echo "=== Résumé ===\n";
echo 'Images valides trouvées: '.count($validImages)."\n\n";

if (count($validImages) >= 5) {
    echo "✅ Nous avons au moins 5 images valides pour le test!\n\n";
    echo "Les 5 premières images valides:\n";
    for ($i = 0; $i < min(5, count($validImages)); $i++) {
        echo ($i + 1).'. '.$validImages[$i]['name'].' ('.$validImages[$i]['width'].'x'.$validImages[$i]['height'].")\n";
    }
} else {
    echo "⚠️  Pas assez d'images valides (besoin de 5, trouvé ".count($validImages).")\n";
    echo "\nImages nécessaires:\n";
    echo "- Dimensions minimales: 800x600 pixels\n";
    echo "- Taille maximale: 10 MB\n";
    echo "- Formats acceptés: JPEG, PNG, GIF, WebP\n";
}

echo "\n";
