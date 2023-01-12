<?php switch($data('level')): case 1: ?>
		<h1><?= $data('text'); ?></h1>
	<?php break;

case 2: ?>
		<h2><?= $data('text'); ?></h2>
	<?php break;

case 3: ?>
		<h3><?= $data('text'); ?></h3>
	<?php break;

case 4: ?>
		<h4><?= $data('text'); ?></h4>
	<?php break;

case 5: ?>
		<h5><?= $data('text'); ?></h5>
	<?php break;

case 6: ?>
		<h6><?= $data('text'); ?></h6>
	<?php break; ?>
<?php endswitch; ?>
