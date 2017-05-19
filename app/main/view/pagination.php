<?php
if (!empty($data['pagination'])):
    $page = $data['pagination']['page'];
    $count = $data['pagination']['count'];
?>
<nav aria-label="Page navigation">
    <ul class="pagination">
        <li <?= $page == 1 ? 'class="disabled"' : '' ?>>
            <a href="<?= $page > 1 ? '?page=' . ($page - 1) : '' ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li <?= $page == 1 ? 'class="active"' : '' ?>><a href="?page=1">1</a></li>
        <?php if ($count > 7): ?>
            <?php if ($page < 5): ?>
                <?php for ($i = 2; $i <= 5; $i++): ?>
                    <li <?= $page == $i ? 'class="active"' : '' ?>><a href="?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor; ?>
                <li class="disabled"><a>...</a></li>
            <?php else: ?>
                <li class="disabled"><a>...</a></li>
                <?php if ($page > $count - 4): ?>
                    <?php for ($i = $count - 4; $i < $count; $i++): ?>
                        <li <?= $page == $i ? 'class="active"' : '' ?>><a href="?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>
                <?php else: ?>
                    <li><a href="?page=<?= $page - 1 ?>"><?= $page - 1 ?></a></li>
                    <li class="active"><a href="?page=<?= $page ?>"><?= $page ?></a></li>
                    <li><a href="?page=<?= $page + 1 ?>"><?= $page + 1 ?></a></li>
                    <li class="disabled"><a>...</a></li>
                <?php endif; ?>
            <?php endif; ?>
        <?php else: ?>
            <?php for ($i = 2; $i < $count; $i++): ?>
                <li <?= $page == $i ? 'class="active"' : '' ?>><a href="?page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor; ?>
        <?php endif; ?>
        <?php if ($count > 1): ?>
            <li <?= $page == $count ? 'class="active"' : '' ?>><a href="?page=<?= $count ?>"><?= $count ?></a></li>
        <?php endif; ?>
        <li <?= $page == $count ? 'class="disabled"' : '' ?>>
            <a href="<?= $page < $count ? '?page=' . ($page + 1) : '' ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
<?php endif; ?>