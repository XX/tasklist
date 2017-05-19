<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Login form</h3>
            </div>
            <div class="panel-body">
                <?php if (isset($data['error'])): ?>
                    <div class="alert alert-danger" role="alert"><?= $data['error'] ?></div>
                <?php endif; ?>
                <form id="login-form" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <label for="inputUsername">User name</label>
                        <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                </form>
            </div>
        </div>
    </div>
</div>