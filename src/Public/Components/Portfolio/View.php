<?php

namespace Vortrixs\Portfolio\Public\Components\Portfolio;

return function (ViewModel $view) { ?>
    <h1>Portfolio!!!</h1>
    <p>Content for portfolio goes here!!!</p>
    <p>This is a prop used from the view: <?= $view->getDescription(); ?></p>
<?php };