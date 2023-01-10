<?php if ($data('style') === 'ordered'): ?>
    <ol>
        <?php foreach ($data('items') as $item): ?>
            <li><?= $item ?></li>
        <?php endforeach; ?>
    </ol>
<?php else: ?>
    <ul>
		<?php foreach ($data('items') as $item): ?>
            <li><?= $item ?></li>
		<?php endforeach; ?>
    </ul>
<?php endif; ?>
