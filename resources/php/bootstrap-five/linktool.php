<div class="bg-light d-flex flex-column flex-sm-row mb-3 overflow-hidden rounded">
    <img
        alt="<?php echo $meta['title']; ?>"
        width="100%"
        src="<?php echo $meta['image']['url']; ?>"
        style="object-fit: cover"
    >
    <div class="flex-2 m-4 rounded bg-white p-4">
        <h4 class="fw-semibold text-xl"><?php echo $meta['title']; ?></h4>
        <p class="mb-3 text-sm">
            <small>
                <a
                    class="link-dark fw-bold"
                    href="<?php echo $link; ?>"
                    target="_blank"
                ><?php echo $link; ?></a>
            </small>
        </p>
        <p class="mb-0"><?php echo $meta['description']; ?></p>
    </div>
</div>
