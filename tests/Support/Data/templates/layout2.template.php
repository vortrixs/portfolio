<?php

return function (string $content, string $head) { ?>
<html>
    <head><?= $head ?></head>
    <body><main><?= $content ?></main></body>
</html>
<?php };