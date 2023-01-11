<table>
    <?php if ($data('withHeadings') && ($headings = $data('content')[array_key_first($data('content'))])): ?>
        <thead>
            <tr>
                <?php foreach ($headings as $heading): ?>
                    <th><?= $heading; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
    <?php endif; ?>

    <tbody>
        <?php foreach ($data('content') as $index => $row): ?>
            <?php
                if ($data('withHeadings') && (array_key_first($data('content')) === $index))
                {
                    continue;
                }
            ?>

            <tr>
                <?php foreach ($row as $cell): ?>
                    <td><?= $cell; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
