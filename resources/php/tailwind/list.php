<?php if($style === 'ordered'): ?>
    <ol class="mb-4 list-decimal pl-8">
        <?php foreach($items as $item): ?>
            <li class="mb-1"><?php echo $item; ?></li>
        <?php endforeach; ?>
    </ol>
<?php else: ?>
    <ul class="mb-4 list-disc pl-8">
        <?php foreach($items as $item): ?>
            <li class="mb-1"><?php echo $item; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
