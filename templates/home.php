<?php

use Vortrixs\Portfolio\Home\View;

return function (View $view) {
?>
<h1>Home!!!</h1>
<p>Content for home goes here!!!</p>
<p>This is a prop used from the view: <?= $view->getHelloWorld(); ?></p>
<?php
};