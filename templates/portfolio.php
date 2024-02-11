<?php

use Vortrixs\Portfolio\Portfolio\View;

return function (View $view) {
?>
    <h1>Portfolio!!!</h1>
    <p>Content for portfolio goes here!!!</p>
    <p>This is a prop used from the view: <?= $view->getDescription(); ?></p>
<?php
};