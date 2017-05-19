<nav id="w0" class="navbar-default navbar-main navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                Task List
            </a>
        </div>
        <div id="w0-collapse" class="collapse navbar-collapse">
            <ul id="w1" class="navbar-nav navbar-right nav">
                <li><a href="/task/add">Add Task</a></li>
                <?php if (empty($user)): ?>
                    <li><a href="/user/login">Login</a></li>
                <?php else: ?>
                    <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><strong><?= $user->username ?></strong> <span class="caret"></span></a>
                        <ul id="w2" class="dropdown-menu">
                            <li><a href="/user/logout" tabindex="-1">Logout</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>