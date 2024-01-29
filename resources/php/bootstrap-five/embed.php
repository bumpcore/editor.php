<div class="mb-3 bg-light p-4 rounded">
    <iframe
        class="block mb-3 rounded bg-white"
        height="<?php echo $height; ?>"
        loading="lazy"
        src="<?php echo $embed; ?>"
        width="100%"
    ></iframe>

    <p class="bg-white p-4 rounded mb-1">
        <?php echo $caption; ?>

    </p>

    <p>
        <small>
            <a
                class="link-secondary"
                href="<?php echo $source; ?>"
				target="_blank"
            ><?php echo $source; ?></a>
        </small>
    </p>

</div>
