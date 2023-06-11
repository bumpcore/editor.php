<div class="mb-3 bg-light p-4 rounded">
    <iframe
        class="block mb-3 rounded bg-white"
        height="<?php echo $data('height'); ?>"
        loading="lazy"
        src="<?php echo $data('embed'); ?>"
        width="100%"
    ></iframe>

    <p class="bg-white p-4 rounded mb-1">
        <?php echo $data('caption'); ?>

    </p>

    <p>
        <small>
            <a
                class="link-secondary"
                href="<?php echo $data('source'); ?>"
				target="_blank"
            ><?php echo $data('source'); ?></a>
        </small>
    </p>

</div>
