<div class="relative overflow-x-auto rounded-xl mb-4 bg-gray-100 pb-6">
    <table class="table w-full text-sm text-left text-gray-500">
        <?php if($data('withHeadings') && ($headings = $data('content')[array_key_first($data('content'))])): ?>
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <?php foreach($headings as $heading): ?>
                        <th class="px-6 py-3"><?php echo $heading; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
        <?php endif; ?>

        <tbody>
            <?php foreach($data('content', []) as $index => $row): ?>
                <?php if($data('withHeadings') && array_key_first($data('content')) === $index): ?>
                    <?php continue; ?>
                <?php endif; ?>

                <tr class="bg-white border-b">
                    <?php foreach($row as $cell): ?>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"><?php echo $cell; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
