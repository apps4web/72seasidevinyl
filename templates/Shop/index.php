<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Record> $records
 * @var string $q
 * @var string $artist
 * @var string $genre
 */
$this->assign('title', 'Onze collectie');

$hasActiveFilters = $artist !== '' || $genre !== '';

function shopUrl(\Cake\View\Helper\UrlHelper $url, array $keep): string {
    $params = array_filter($keep, fn($v) => $v !== '');
    return $url->build(['controller' => 'Shop', 'action' => 'index', '?' => $params]);
}
?>

<div class="shop-page">

    <!-- Page header -->
    <div class="shop-index-header">
        <div class="container">
            <h1 class="shop-index-title">Onze collectie</h1>
            <p class="shop-index-subtitle">Vinylplaten te koop bij 72 Seaside Vinyl, Zierikzee</p>
        </div>
    </div>

    <div class="container shop-index-body">

        <!-- Search form -->
        <form method="get" action="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'index']) ?>" class="shop-search">
            <?php if ($artist !== ''): ?>
                <input type="hidden" name="artist" value="<?= h($artist) ?>">
            <?php endif; ?>
            <?php if ($genre !== ''): ?>
                <input type="hidden" name="genre" value="<?= h($genre) ?>">
            <?php endif; ?>
            <label for="shop-q" class="sr-only">Zoek op artiest of album</label>
            <input
                type="search"
                id="shop-q"
                name="q"
                value="<?= h($q) ?>"
                placeholder="Zoek op artiest of album&hellip;"
                class="shop-search__input"
                autocomplete="off"
            >
            <button type="submit" class="shop-search__btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <span>Zoeken</span>
            </button>
        </form>

        <!-- Active filter chips -->
        <?php if ($hasActiveFilters): ?>
        <div class="shop-filter-chips">
            <?php if ($artist !== ''): ?>
                <span class="shop-filter-chip">
                    <span class="shop-filter-chip__label">Artiest:</span>
                    <?= h($artist) ?>
                    <a href="<?= h(shopUrl($this->Url, ['q' => $q, 'genre' => $genre])) ?>" class="shop-filter-chip__remove" aria-label="Verwijder artiest filter">&times;</a>
                </span>
            <?php endif; ?>
            <?php if ($genre !== ''): ?>
                <span class="shop-filter-chip">
                    <span class="shop-filter-chip__label">Genre:</span>
                    <?= h($genre) ?>
                    <a href="<?= h(shopUrl($this->Url, ['q' => $q, 'artist' => $artist])) ?>" class="shop-filter-chip__remove" aria-label="Verwijder genre filter">&times;</a>
                </span>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Results meta -->
        <p class="shop-results-meta">
            <?= $this->Paginator->counter('{{count}} platen gevonden') ?>
            <?php if ($q !== '' || $hasActiveFilters): ?>
                &mdash; <a href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'index']) ?>">Alles tonen</a>
            <?php endif; ?>
        </p>

        <!-- Record grid -->
        <?php if ($this->Paginator->total() === 0): ?>
            <div class="shop-empty">
                <p>Geen platen gevonden voor uw zoekopdracht.</p>
                <a href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'index']) ?>" class="btn-reserve" style="display:inline-block; margin-top: 20px;">
                    Alles tonen
                </a>
            </div>
        <?php else: ?>
            <div class="shop-records-grid">
                <?php foreach ($records as $record): ?>
                    <a href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'record', $record->id]) ?>" class="record-card">
                        <div class="record-card__image">
                            <?php if ($record->cover): ?>
                                <img
                                    src="<?= h($this->Url->assetUrl('img/records/images/' . $record->cover)) ?>"
                                    alt="<?= h($record->name) ?>"
                                    loading="lazy"
                                >
                            <?php else: ?>
                                <div class="record-card__no-cover">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <p class="record-card__artist">
                            <?= h($record->artist ? $record->artist->name : '') ?>
                        </p>
                        <p class="record-card__title"><?= h($record->name) ?></p>
                        <div class="record-card__meta">
                            <span><?= $record->released ? h($record->released->format('Y')) : '' ?></span>
                            <?php if ($record->price !== null): ?>
                                <span class="record-card__price">&euro;&nbsp;<?= h(number_format((float)$record->price, 2, ',', '.')) ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if (!$record->in_stock): ?>
                            <span class="record-stock record-stock--out" style="margin-top:6px; font-size:0.72rem;">Niet op voorraad</span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($this->Paginator->total() > 1): ?>
            <div class="shop-pagination">
                <?= $this->Paginator->prev('‹') ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('›') ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</div>
