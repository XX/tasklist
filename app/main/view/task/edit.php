<?php $task = $data['task']; ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Edit Task <?= $task->id ?></h2>
    </div>
    <div class="panel-body">
        <img src="<?= $task->image_uri ?>" class="img-thumbnail" />
        <form class="form-horizontal" enctype="multipart/form-data" method="post">
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
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="status" value="done" <?= $task->status === 'done' ? 'checked' : '' ?>> is done
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="inputDescription">Task description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="inputDescription" name="description" rows="3"><?= $task->description ?></textarea>
                </div>
            </div>
            <div class="col-sm-2 control-label">
                <input type="hidden" name="id" value="<?= $task->id ?>">
                <a href="/task/view/<?= $task->id ?>" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
