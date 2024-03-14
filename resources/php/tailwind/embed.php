<div class="mb-4 bg-gray-100 p-4 rounded-xl">
    <iframe
        class="block mb-4 rounded-xl bg-white"
        height="<?php echo $height; ?>"
        loading="lazy"
        src="<?php echo $embed; ?>"
        width="100%"
    ></iframe>

    <p class="bg-white p-4 rounded-xl mb-1">
        <?php echo $caption; ?>

    </p>

    <p>
        <small>
            <a
                class="text-gray-400 hover:text-gray-700"
                href="<?php echo $source; ?>"
				target="_blank"
            ><?php echo $source; ?></a>
        </small>
    </p>

</div>
