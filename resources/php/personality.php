<div>
    <p>
        <img
            alt="<?= $data('name'); ?>"
            src="<?= $data('photo'); ?>"
            style="max-width: 16rem;"
        >
    </p>
    <h4><?= $data('name'); ?></h4>
    <p><?= $data('description'); ?></p>
    <p>
        <small>
            <a href="<?= $data('link'); ?>"><?= $data('link'); ?></a>
        </small>
    </p>
</div>
