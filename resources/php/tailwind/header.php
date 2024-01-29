<?php switch($level):
    case (1): ?>
        <h1 class="text-5xl font-bold mb-4"><?= $text; ?></h1>
    <?php break; ?>

    <?php case (2): ?>
        <h2 class="text-3xl font-bold mb-4"><?= $text; ?></h2>
    <?php break; ?>

    <?php case (3): ?>
        <h3 class="text-2xl font-bold mb-2"><?= $text; ?></h3>
    <?php break; ?>

    <?php case (4): ?>
        <h4 class="text-xl font-semibold mb-2"><?= $text; ?></h4>
    <?php break; ?>

    <?php case (5): ?>
        <h5 class="text-base font-semibold mb-2"><?= $text; ?></h5>
    <?php break; ?>

    <?php case (6): ?>
        <h6 class="text-sm font-semibold mb-1"><?= $text; ?></h6>
    <?php break; ?>
<?php endswitch; ?>
