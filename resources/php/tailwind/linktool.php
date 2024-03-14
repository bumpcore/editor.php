<div class="bg-gray-100 flex mb-4 rounded-xl overflow-hidden flex-col sm:flex-row">
    <img
        alt="<?php echo $meta['title']; ?>"
        class="sm:max-w-[16rem] object-cover grow sm:grow-0"
        src="<?php echo $meta['image']['url']; ?>"
    >
    <div class="m-4 p-4 bg-white rounded-xl flex-1">
        <h4 class="text-xl font-semibold"><?php echo $meta['title']; ?></h4>
        <p class="mb-2 text-sm">
            <small>
                <a
                    class="text-black hover:text-gray-600 font-bold"
                    href="<?php echo $link; ?>"
                    target="_blank"
                ><?php echo $link; ?></a>
            </small>
        </p>
        <p><?php echo $meta['description']; ?></p>
    </div>
</div>
