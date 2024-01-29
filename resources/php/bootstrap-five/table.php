<div class="table-responsive bg-light mb-3 rounded pb-6">
    <table class="table w-full">
        <?php if($withHeadings && ($headings = $content[array_key_first($content)])): ?>
            <thead class="text-uppercase bg-light text-gray-700">
                <tr>
                    <?php foreach($headings as $heading): ?>
                        <th class="px-4 py-3"><?= $heading; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
        <?php endif; ?>

        <tbody>
            <?php foreach($content as $index => $row): ?>
                <?php if($withHeadings && array_key_first($content) === $index): ?>
                    <?php continue; ?>
                <?php endif; ?>

                <tr class="bg-white">
                    <?php foreach($row as $cell): ?>
                        <td class="fw-semibold px-4 py-3"><?= $cell; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
