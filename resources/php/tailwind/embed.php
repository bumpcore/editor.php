<div class="mb-4 bg-gray-100 p-4 rounded-xl">
    <iframe
        class="block mb-4 rounded-xl bg-white"
        height="<?= $data('height'); ?>"
        loading="lazy"
        src="<?= $data('embed'); ?>"
        width="100%"
    ></iframe>

    <p class="bg-white p-4 rounded-xl mb-1">
        <?= $data('caption'); ?>

    </p>

    <p>
        <small>
            <a
                class="text-gray-400 hover:text-gray-700"
                href="<?= $data('source'); ?>"
				target="_blank"
            ><?= $data('source'); ?></a>
        </small>
    </p>

</div>
