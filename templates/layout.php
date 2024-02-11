<?php

return function (string $content, string $head = null) {
?>
<html lang="en">
    <head>
        <title>Hans Erik Jepsen | Full-stack Developer | he-jepsen.dk</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css" />
        <meta property="twitter:card" content="summary_large_image">
        <meta property="og:site_name" content="Hans Erik Jepsen | Full-stack Developer | he-jepsen.dk">
        <?= $head ?>
    </head>
    <body>
        <header>
            <nav>
                <a href="/">Home</a>
                <a href="/portfolio">Portfolio</a>
            </nav>
        </header>
        <main>
            <?= $content ?>
        </main>
    </body>
</html>
<?php
};