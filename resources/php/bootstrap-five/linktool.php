<div class="bg-light d-flex mb-3 rounded overflow-hidden flex-column flex-sm-row">
    <img
        alt="<?php echo $data('meta.title'); ?>"
        width="100%"
        src="<?php echo $data('meta.image.url'); ?>"
		style="object-fit: cover"
    >
    <div class="m-4 p-4 bg-white rounded flex-2">
        <h4 class="text-xl fw-semibold"><?php echo $data('meta.title'); ?></h4>
        <p class="mb-3 text-sm">
            <small>
                <a
                    class="link-dark fw-bold"
                    href="<?php echo $data('link'); ?>"
                    target="_blank"
                ><?php echo $data('link'); ?></a>
            </small>
        </p>
        <p class="mb-0"><?php echo $data('meta.description'); ?></p>
    </div>
</div>
