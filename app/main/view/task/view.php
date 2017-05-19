<?php
$task = $data['task'];
$editable = isset($data['editable']) ? $data['editable'] : false;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Task <?= $task->id ?></h2>
    </div>
    <div class="panel-body">
        <img src="<?= $task->image_uri ?>" class="img-thumbnail" />
        <div class="row">
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">User name</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $task->username ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $task->email ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?= $task->status ?></p>
                    </div>
                </div>
            </form>
        </div>
        <p class="lead"><?= $task->description ?></p>
    </div>
</div>
<?php if ($editable): ?>
    <a href="/task/edit/<?= $task->id ?>" class="btn btn-primary">Edit</a>
<?php endif; ?>
