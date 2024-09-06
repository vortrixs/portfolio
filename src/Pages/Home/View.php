<?php

namespace Vortrixs\Portfolio\Pages\Home;

return function (ViewModel $viewModel) { ?>
    <h1>CV</h1>
    <?php foreach ($viewModel->getCvList() as $cv) : ?>
        <article class="card">
            <h2 class="card__title"><?= $cv['position'] ?> @ <?= $cv['company'] ?></h2>
            <p class="card__line"><?= $cv['length'] ?></p>
            <p class="card__line"><?= implode(', ', $cv['tags']) ?></p>
            <p class="card__text"><?= $cv['description'] ?></p>
        </article>
    <?php endforeach; ?>
<?php };
