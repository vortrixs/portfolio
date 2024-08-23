<?php

namespace Vortrixs\Portfolio\Pages\Home;

return function (ViewModel $viewModel) { ?>
    <h1>CV</h1>
    <?php foreach ($viewModel->getCvList() as $cv) : ?>
        <article class="card">
            <h2><?= $cv['position'] ?> @ <?= $cv['company'] ?></h2>
            <p><?= $cv['length'] ?></p>
            <p><?= $cv['tags'] ?></p>
            <p><?= $cv['description'] ?></p>
        </article>
    <?php endforeach; ?>
<?php };
