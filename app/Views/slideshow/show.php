<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>COLOC NEXT - Slideshow</title>
</head>

<body>

    <h1>Slideshow V1</h1>

    <p>
        Image <?= $index + 1 ?> / <?= $count ?>
    </p>

    <div style="margin-bottom:20px;">

        <?php if ($index > 0): ?>
            <a href="<?= site_url('slideshow/' . ($index - 1)) ?>">← Précédente</a>
        <?php endif; ?>

        <?php if ($index < ($count - 1)): ?>
            <a href="<?= site_url('slideshow/' . ($index + 1)) ?>" style="margin-left:20px;">
                Suivante →
            </a>
        <?php endif; ?>

    </div>

    <div>
        <img
            src="<?= esc($slide['url']) ?>"
            style="max-width:900px; max-height:700px;">
    </div>

    <p>
        <?= esc($slide['filename']) ?>
    </p>

</body>

</html>