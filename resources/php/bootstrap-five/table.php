<div class="table-responsive rounded mb-3 bg-light pb-6">
    <table class="table w-full">
        <?php if($data('withHeadings') && ($headings = $data('content')[array_key_first($data('content'))])): ?>
            <thead class=" text-gray-700 text-uppercase bg-light">
                <tr>
                    <?php foreach($headings as $heading): ?>
                        <th class="px-4 py-3"><?php echo $heading; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
        <?php endif; ?>

        <tbody>
            <?php foreach($data('content', []) as $index => $row): ?>
                <?php if($data('withHeadings') && array_key_first($data('content')) === $index): ?>
                    <?php continue; ?>
                <?php endif; ?>

                <tr class="bg-white">
                    <?php foreach($row as $cell): ?>
                        <td class="px-4 py-3 fw-semibold"><?php echo $cell; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
