<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Record $record
 * @var string $title
 */

$this->assign('title', $title);

function youtubeEmbedUrl(string $url): ?string {
    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_\-]+)/', $url, $m)) {
        return 'https://www.youtube.com/embed/' . $m[1];
    }
    return null;
}

$artistsByType = [];
foreach ($record->records_artists ?? [] as $ra) {
    $artistsByType[$ra->type][] = $ra;
}

$primaryArtistName = '';
if (!empty($artistsByType['artist'])) {
    $names = array_map(fn($ra) => h($ra->company->name), $artistsByType['artist']);
    $primaryArtistName = implode(', ', $names);
} elseif ($record->hasValue('artist')) {
    $primaryArtistName = h($record->artist->name);
}

$hasTracks  = !empty($record->tracks);
$hasCredits = !empty($artistsByType);
$hasGenres = !empty($record->genres);

$coverUrl = $record->cover
    ? $this->Url->assetUrl('img/records/images/' . $record->cover)
    : null;

$extraImages = $record->record_images ?? [];
$hasGallery  = $record->cover && count($extraImages) > 0;

$session = $this->request->getSession();
$basket = (array)($session->read('Basket') ?? []);
$inBasket = isset($basket[$record->id]);
?>

<div class="shop-page">

    <!-- Record hero: cover + info -->
    <div class="record-detail container">
        <div class="record-detail__cover">
            <?php if ($coverUrl): ?>
                <?php if ($hasGallery): ?>
                    <button type="button" class="record-cover-trigger"
                        data-gallery-trigger
                        data-gallery-src="<?= h($coverUrl) ?>"
                        data-gallery-alt="<?= h($record->name) ?>"
                        data-gallery-caption="<?= h($primaryArtistName . ' – ' . $record->name) ?>">
                        <img src="<?= h($coverUrl) ?>" alt="<?= h($record->name) ?>" class="record-cover-img">
                        <span class="record-cover-zoom" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                        </span>
                    </button>
                <?php else: ?>
                    <img src="<?= h($coverUrl) ?>" alt="<?= h($record->name) ?>" class="record-cover-img">
                <?php endif; ?>
            <?php else: ?>
                <div class="record-cover-placeholder">
                    <span>Geen afbeelding</span>
                </div>
            <?php endif; ?>

            <?php if ($hasGallery): ?>
                <div class="record-thumbnails">
                    <?php foreach ($extraImages as $img): ?>
                        <?php $imgUrl = $this->Url->assetUrl('img/records/images/' . $img->filename); ?>
                        <button type="button" class="record-thumbnail-btn"
                            data-gallery-trigger
                            data-gallery-src="<?= h($imgUrl) ?>"
                            data-gallery-alt="<?= h($img->alt ?? $record->name) ?>"
                            data-gallery-caption="">
                            <img src="<?= h($imgUrl) ?>" alt="<?= h($img->alt ?? $record->name) ?>" class="record-thumbnail-img" loading="lazy">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="record-detail__info">

            <?php
            $artistFilterUrl = $record->hasValue('artist')
                ? $this->Url->build(['controller' => 'Shop', 'action' => 'index', '?' => ['artist' => $record->artist->name]])
                : null;
            ?>
            <p class="record-detail__artist">
                <?php if ($artistFilterUrl): ?>
                    <a href="<?= h($artistFilterUrl) ?>" class="record-detail__artist-link"><?= $primaryArtistName ?></a>
                <?php else: ?>
                    <?= $primaryArtistName ?>
                <?php endif; ?>
            </p>
            <h1 class="record-detail__title"><?= h($record->name) ?></h1>

            <?php if ($record->released): ?>
                <?php
                $dutchMonths = ['januari','februari','maart','april','mei','juni','juli','augustus','september','oktober','november','december'];
                $month = (int)$record->released->format('n');
                $releasedLabel = ucfirst($dutchMonths[$month - 1]) . ' ' . $record->released->format('Y');
                ?>
                <p class="record-detail__year"><?= h($releasedLabel) ?></p>
            <?php endif; ?>

            <div class="record-detail__price-block">
                <?php if ($record->price !== null): ?>
                    <p class="record-detail__price">&euro;&nbsp;<?= h(number_format((float)$record->price, 2, ',', '.')) ?></p>
                <?php endif; ?>

                <p class="record-pickup">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Ophalen in de winkel &mdash; Sint Domusstraat 17, Zierikzee
                </p>
            </div>

            <?php if ($record->in_stock): ?>
                <span class="record-stock record-stock--in">Op voorraad</span>
            <?php else: ?>
                <span class="record-stock record-stock--out">Momenteel niet op voorraad</span>
            <?php endif; ?>

            <div class="record-reserve-block">
                <?php if ($inBasket): ?>
                    <a href="<?= $this->Url->build(['controller' => 'Basket', 'action' => 'view']) ?>" class="btn-basket btn-basket--in-basket">
                        In winkelwagen &rarr;
                    </a>
                    <p class="record-reserve-note">Dit album staat al in uw winkelwagen.</p>
                <?php else: ?>
                    <?= $this->Form->postLink(
                        'Voeg toe aan winkelwagen',
                        ['controller' => 'Basket', 'action' => 'add', $record->id],
                        ['class' => 'btn-basket']
                    ) ?>
                    <p class="record-reserve-note">Ophalen in de winkel &mdash; u reserveert via de winkelwagen.</p>
                <?php endif; ?>
            </div>

            <?php if ($hasGenres): ?>
                <div class="genre-badges">
                    <?php foreach ($record->genres as $genre): ?>
                        <a href="<?= h($this->Url->build(['controller' => 'Shop', 'action' => 'index', '?' => ['genre' => $genre->name]])) ?>" class="genre-badge genre-badge--link"><?= h($genre->name) ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tracklist -->
    <?php if ($hasTracks): ?>
    <section class="record-section-wrap">
        <div class="record-section container">
            <h2 class="record-section-title">Nummers</h2>
            <ol class="tracklist">
                <?php foreach ($record->tracks as $track): ?>
                    <?php if ($track->track_type === 'heading'): ?>
                        <li class="tracklist__heading"><?= h($track->title) ?></li>
                    <?php else: ?>
                        <li class="tracklist__item">
                            <?php if ($track->position): ?>
                                <span class="tracklist__position"><?= h($track->position) ?></span>
                            <?php endif; ?>
                            <span class="tracklist__title"><?= h($track->title) ?></span>
                            <?php if ($track->duration): ?>
                                <span class="tracklist__duration"><?= h($track->duration) ?></span>
                            <?php endif; ?>
                            <?php if ($track->video): ?>
                                <button type="button" class="tracklist__video-link" data-youtube="<?= h($track->video) ?>" title="Bekijk op YouTube">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 7s-.3-2-1.2-2.8c-1.1-1.2-2.4-1.2-3-1.3C16.4 2.8 12 2.8 12 2.8s-4.4 0-6.8.1c-.6.1-1.9.1-3 1.3C1.3 5 1 7 1 7S.7 9.1.7 11.2v2c0 2 .3 4.1.3 4.1s.3 2 1.2 2.8c1.1 1.2 2.6 1.1 3.3 1.2C7.6 21.4 12 21.5 12 21.5s4.4 0 6.8-.2c.6-.1 1.9-.1 3-1.3.9-.8 1.2-2.8 1.2-2.8s.3-2.1.3-4.1v-2C23.3 9.1 23 7 23 7zM9.7 15.5V8.4l8.1 3.6-8.1 3.5z"/></svg>
                                    Bekijk
                                </button>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>
    <?php endif; ?>

    <!-- Credits / Companies -->
    <?php if ($hasCredits): ?>
    <section class="record-section-wrap">
        <div class="record-section container">
            <h2 class="record-section-title">Credits</h2>
            <div class="credits-grid">
                <?php if (!empty($artistsByType['artist'])): ?>
                    <div class="credits-group">
                        <h3>Artiest</h3>
                        <ul>
                            <?php foreach ($artistsByType['artist'] as $ra): ?>
                                <li>
                                    <?= h($ra->company->name) ?>
                                    <?php if ($ra->role): ?>
                                        <span class="credits-role"><?= h($ra->role) ?></span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($artistsByType['label'])): ?>
                    <div class="credits-group">
                        <h3>Label</h3>
                        <ul>
                            <?php foreach ($artistsByType['label'] as $ra): ?>
                                <li><?= h($ra->company->name) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($artistsByType['company'])): ?>
                    <div class="credits-group">
                        <h3>Bedrijven</h3>
                        <ul>
                            <?php foreach ($artistsByType['company'] as $ra): ?>
                                <li>
                                    <?= h($ra->company->name) ?>
                                    <?php if ($ra->role): ?>
                                        <span class="credits-role"><?= h($ra->role) ?></span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- YouTube video modal -->
    <div class="video-modal" id="video-modal" hidden aria-modal="true" role="dialog" aria-label="Video afspelen">
        <div class="video-modal__backdrop"></div>
        <div class="video-modal__content">
            <button type="button" class="video-modal__close" id="video-modal-close" aria-label="Sluit video">&times;</button>
            <div class="video-embed">
                <iframe id="video-modal-iframe" src="" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <?php if ($hasGallery): ?>
    <div class="gallery-lightbox" data-gallery-lightbox hidden aria-hidden="true">
        <button type="button" class="gallery-lightbox-close" data-gallery-close aria-label="Sluit fotoviewer">&times;</button>
        <button type="button" class="gallery-lightbox-nav gallery-lightbox-prev" data-gallery-prev aria-label="Vorige foto">&#8249;</button>
        <figure class="gallery-lightbox-figure">
            <img src="" alt="" class="gallery-lightbox-image" data-gallery-image>
            <figcaption class="gallery-lightbox-caption" data-gallery-caption></figcaption>
        </figure>
        <button type="button" class="gallery-lightbox-nav gallery-lightbox-next" data-gallery-next aria-label="Volgende foto">&#8250;</button>
    </div>
    <?php endif; ?>

</div>

<?php $this->append('script') ?>
<script>
(function () {
    var modal  = document.getElementById('video-modal');
    var iframe = document.getElementById('video-modal-iframe');
    var close  = document.getElementById('video-modal-close');

    if (!modal || !iframe) return;

    function youtubeEmbedUrl(url) {
        var m = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_\-]+)/);
        return m ? 'https://www.youtube.com/embed/' + m[1] + '?autoplay=1' : null;
    }

    function openModal(url) {
        var embed = youtubeEmbedUrl(url);
        if (!embed) return;
        iframe.src = embed;
        modal.hidden = false;
        document.body.classList.add('lightbox-open');
    }

    function closeModal() {
        modal.hidden = true;
        iframe.src = '';
        document.body.classList.remove('lightbox-open');
    }

    document.querySelectorAll('[data-youtube]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            openModal(btn.getAttribute('data-youtube'));
        });
    });

    close.addEventListener('click', closeModal);

    modal.querySelector('.video-modal__backdrop').addEventListener('click', closeModal);

    document.addEventListener('keydown', function (e) {
        if (!modal.hidden && e.key === 'Escape') closeModal();
    });
})();
</script>
<?php $this->end() ?>
