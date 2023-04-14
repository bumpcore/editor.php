<?php switch($data('level')):
    case (1): ?>
        <h1 class="fw-bold mb-3"><?php echo $data('text'); ?></h1>
    <?php break; ?>

    <?php case (2): ?>
        <h2 class="fw-bold mb-3"><?php echo $data('text'); ?></h2>
    <?php break; ?>

    <?php case (3): ?>
        <h3 class="fw-bold mb-3"><?php echo $data('text'); ?></h3>
    <?php break; ?>

    <?php case (4): ?>
        <h4 class="fw-semibold mb-3"><?php echo $data('text'); ?></h4>
    <?php break; ?>

    <?php case (5): ?>
        <h5 class="fw-semibold mb-3"><?php echo $data('text'); ?></h5>
    <?php break; ?>

    <?php case (6): ?>
        <h6 class="fw-semibold mb-1"><?php echo $data('text'); ?></h6>
    <?php break; ?>
<?php endswitch; ?>
