<div>
    <?php foreach ($data('items', []) as $item): ?>
        <label style="display: block;">
            <input
				<?= $item['checked'] ? 'checked' : ''; ?>
                disabled
                type="checkbox"
            />
            <span><?= $item['text']; ?></span>
        </label>
    <?php endforeach; ?>
</div>
