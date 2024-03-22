<?php

namespace Vortrixs\Portfolio\Components\Navigation;

return function (ViewModel $view) { ?>
    <nav>
        <?php foreach ($view->getPages() as $page) : ?>
            <a href="<?= $page['url'] ?>"><?= $page['label'] ?></a>
        <?php endforeach; ?>
    </nav>
<?php };
