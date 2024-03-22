<?php

namespace Vortrixs\Portfolio\Layout;

return function (ViewModel $view) {
?>
<html lang="en">
    <head>
        <title>Hans Erik Jepsen | Full-stack Developer | he-jepsen.dk</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css" />
        <meta property="twitter:card" content="summary_large_image">
        <meta property="og:site_name" content="Hans Erik Jepsen | Full-stack Developer | he-jepsen.dk">
        <?= $view->head ?>
    </head>
    <body>
        <header>
            <?= $view->header ?>
        </header>
        <main>
            <?= $view->content ?>
        </main>
    </body>
</html>
<?php
};