<div class="bg-light d-flex mb-3 rounded overflow-hidden flex-column flex-sm-row">
    <img
        alt="<?php echo $name; ?>"
        src="<?php echo $photo; ?>"
        style="object-fit: cover"
        width="100%"
    >
    <div class="m-4 p-4 bg-white rounded flex-2">
        <h4 class="text-xl fw-semibold"><?php echo $name; ?></h4>
        <p class="mb-3 text-sm">
            <small>
                <a
				class="link-dark fw-bold"
				href="<?php echo $link; ?>"
                    target="_blank"
                ><?php echo $link; ?></a>
            </small>
        </p>
        <p class="mb-0"><?php echo $description; ?></p>
    </div>
</div>
