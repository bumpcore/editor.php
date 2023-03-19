<div class="bg-gray-100 flex mb-4 rounded-xl overflow-hidden flex-col sm:flex-row">
    <img
        alt="<?= $data('name'); ?>"
        class="sm:max-w-[16rem] object-cover grow sm:grow-0"
        src="<?= $data('photo'); ?>"
    >
    <div class="m-4 p-4 bg-white rounded-xl flex-1">
        <h4 class="text-xl font-semibold"><?= $data('name'); ?></h4>
        <p class="mb-2 text-sm">
            <small>
                <a
                    class="text-black hover:text-gray-600 font-bold"
                    href="<?= $data('link'); ?>"
                    target="_blank"
                ><?= $data('link'); ?></a>
            </small>
        </p>
        <p><?= $data('description'); ?></p>
    </div>
</div>
