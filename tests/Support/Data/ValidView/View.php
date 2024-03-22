<?php

namespace Tests\Support\Data\ValidView;

return function (ViewModel $view) { ?>
<html>
    <head></head>
    <body><main><?= $view->getHelloWorld() ?></main></body>
</html>
<?php };