<div class="bg-light d-flex mb-3 rounded overflow-hidden flex-column flex-sm-row">
    <img
        alt="<?php echo $data('name'); ?>"
        src="<?php echo $data('photo'); ?>"
        style="object-fit: cover"
        width="100%"
    >
    <div class="m-4 p-4 bg-white rounded flex-2">
        <h4 class="text-xl fw-semibold"><?php echo $data('name'); ?></h4>
        <p class="mb-3 text-sm">
            <small>
                <a
				class="link-dark fw-bold"
				href="<?php echo $data('link'); ?>"
                    target="_blank"
                ><?php echo $data('link'); ?></a>
            </small>
        </p>
        <p class="mb-0"><?php echo $data('description'); ?></p>
    </div>
</div>
