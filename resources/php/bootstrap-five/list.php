<?php if($data('style') === 'ordered'): ?>
    <ol class="mb-3">
        <?php foreach($data('items', []) as $item): ?>
            <li class="mb-1"><?php echo $item; ?></li>
        <?php endforeach; ?>
    </ol>
<?php else: ?>
    <ul class="mb-3">
        <?php foreach($data('items', []) as $item): ?>
            <li class="mb-1"><?php echo $item; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
