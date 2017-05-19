<div class="row">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>id</th>
                <th>image</th>
                <th>description</th>
                <th>user</th>
                <th>e-mail</th>
                <th>status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['tasks'] as $task):?>
            <tr class="clickable-row" data-href="/task/view/<?= $task->id ?>">
                <td><?= $task->id ?></td>
                <td><img src="<?= $task->image_uri ?>" class="img-thumbnail" /></td>
                <td><?= $task->description ?></td>
                <td><?= $task->username ?></td>
                <td><?= $task->email ?></td>
                <td><?= $task->status ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php require dirname(__DIR__) . '/pagination.php'; ?>
</div>

<script>
    $(function () {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
</script>