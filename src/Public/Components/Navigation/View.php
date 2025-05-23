<?php

namespace Vortrixs\Portfolio\Public\Components\Navigation;

return function (ViewModel $view) { ?>
    <nav>
        <?php foreach ($view->getPages() as $page) : ?>
            <a 
                href="<?= $page['url'] ?>"
                <?= $page['active'] ? 'class="active"' : '' ?>
            >
                <?= $page['label'] ?>
            </a>
        <?php endforeach; ?>
    </nav>
<?php };
