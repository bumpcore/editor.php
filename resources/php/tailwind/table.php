<div class="relative mb-4 overflow-x-auto rounded-xl bg-gray-100 pb-6">
    <table class="table w-full text-left text-sm text-gray-500">
        <?php if($withHeadings && ($headings = $content[array_key_first($content)])): ?>
            <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                <tr>
                    <?php foreach($headings as $heading): ?>
                        <th class="px-6 py-3"><?php echo $heading; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
        <?php endif; ?>

        <tbody>
            <?php foreach($content as $index => $row): ?>
                <?php if($withHeadings && array_key_first($content) === $index): ?>
                    <?php continue; ?>
                <?php endif; ?>

                <tr class="border-b bg-white">
                    <?php foreach($row as $cell): ?>
                        <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900"><?php echo $cell; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
