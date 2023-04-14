<?php if($data('style') === 'ordered'): ?>
    <ol class="pl-8 mb-4 list-decimal">
        <?php foreach($data('items', []) as $item): ?>
            <li class="mb-1"><?= $item; ?></li>
        <?php endforeach; ?>
    </ol>
<?php else: ?>
    <ul class="pl-8 mb-4 list-disc">
        <?php foreach($data('items', []) as $item): ?>
            <li class="mb-1"><?= $item; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
