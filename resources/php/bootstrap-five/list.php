<?php if($style === 'ordered'): ?>
    <ol class="mb-3">
        <?php foreach($items as $item): ?>
            <li class="mb-1"><?= $item; ?></li>
        <?php endforeach; ?>
    </ol>
<?php else: ?>
    <ul class="mb-3">
        <?php foreach($items as $item): ?>
            <li class="mb-1"><?= $item; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
