<?php
/**
 * @var \App\View\AppView $this
 * @var array $latestReleases
 */
$this->assign('title', 'Home');
?>

<!-- ============================================================
     HERO SECTION
     ============================================================ -->
<section class="hero" id="home">
    <img src="<?= $this->Url->image('store-exterior.jpg') ?>"
         alt="72 Seaside Vinyl – de winkel aan Zierikzee"
         class="hero-bg-img"
         loading="eager">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">72 Seaside Vinyl</h1>
        <p class="hero-subtitle">Jouw platenwinkel aan de kust &mdash; Zierikzee</p>
        <a href="#about" class="btn btn-primary">Ontdek Onze Winkel</a>
    </div>
</section>

<!-- ============================================================
     ABOUT US SECTION
     ============================================================ -->
<section class="about" id="about">
    <div class="container">
        <div class="section-header">
            <h2>Over Ons</h2>
            <div class="section-divider"></div>
        </div>
        <div class="about-content">
            <div class="about-text">
                <h3>Een passie voor vinyl</h3>
                <p>
                    Welkom bij <strong>72 Seaside Vinyl</strong>, de platenwinkel van Zierikzee.
                    Gevestigd in het hart van deze historische Zeeuwse stad, bieden wij een
                    zorgvuldig samengestelde collectie nieuwe en tweedehands vinylplaten voor
                    elke muziekliefhebber.
                </p>
                <p>
                    Ons team bestaat uit echte platenliefhebbers die hun kennis en enthousiasme
                    graag met je delen. Of je nu op zoek bent naar een zeldzame klassieker, het
                    nieuwste album van je favoriete artiest of gewoon wilt browsen door onze
                    uitgebreide collectie &mdash; bij ons ben je aan het juiste adres.
                </p>
                <p>
                    Naast onze reguliere collectie organiseren we regelmatig luistermiddagen,
                    plaatjesdagen en andere evenementen voor de lokale vinyl-community. Want
                    muziek is meer dan een product &mdash; het is een beleving.
                </p>
            </div>
            <div class="about-highlights">
                <div class="highlight-card">
                    <span class="highlight-icon">&#9679;</span>
                    <h4>New Releases</h4>
                    <p>Always the latest records in stock, week after week.</p>
                </div>
                <div class="highlight-card">
                    <span class="highlight-icon">&#9679;</span>
                    <h4>Tweedehands</h4>
                    <p>Een groeiende collectie zorgvuldig geselecteerde tweedehands platen.</p>
                </div>
                <div class="highlight-card">
                    <span class="highlight-icon">&#9679;</span>
                    <h4>Advies op Maat</h4>
                    <p>Persoonlijk advies van onze enthousiaste medewerkers.</p>
                </div>
                <div class="highlight-card">
                    <span class="highlight-icon">&#9679;</span>
                    <h4>Luisterhoek</h4>
                    <p>Beluister platen voordat je ze koopt in onze gezellige luisterhoek.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     STORE PHOTOS SECTION
     ============================================================ -->
<section class="store-photos">
    <div class="container">
        <div class="photo-grid">
            <div class="photo-item photo-large">
                <button
                    type="button"
                    class="photo-frame"
                    data-gallery-trigger
                    data-gallery-src="<?= $this->Url->image('vinyl-shelves.jpg') ?>"
                    data-gallery-alt="Ons assortiment vinyl platen op de schappen"
                    data-gallery-caption="Ons Assortiment"
                    aria-label="Bekijk foto groot: Ons Assortiment"
                >
                    <img src="<?= $this->Url->image('vinyl-shelves.jpg') ?>"
                         alt="Ons assortiment vinyl platen op de schappen"
                         class="photo-img"
                         loading="lazy">
                    <span class="photo-caption">Ons Assortiment</span>
                </button>
            </div>
            <div class="photo-item">
                <button
                    type="button"
                    class="photo-frame"
                    data-gallery-trigger
                    data-gallery-src="<?= $this->Url->image('records-cashier.jpg') ?>"
                    data-gallery-alt="De Records sectie met kassabalie"
                    data-gallery-caption="Records"
                    aria-label="Bekijk foto groot: Records"
                >
                    <img src="<?= $this->Url->image('records-cashier.jpg') ?>"
                         alt="De Records sectie met kassabalie"
                         class="photo-img"
                         loading="lazy">
                    <span class="photo-caption">Records</span>
                </button>
            </div>
            <div class="photo-item">
                <button
                    type="button"
                    class="photo-frame"
                    data-gallery-trigger
                    data-gallery-src="<?= $this->Url->image('listening-corner.jpg') ?>"
                    data-gallery-alt="De gezellige koffiehoek en balie"
                    data-gallery-caption="Luisterhoek &amp; Koffie"
                    aria-label="Bekijk foto groot: Luisterhoek en Koffie"
                >
                    <img src="<?= $this->Url->image('listening-corner.jpg') ?>"
                         alt="De gezellige koffiehoek en balie"
                         class="photo-img"
                         loading="lazy">
                    <span class="photo-caption">Luisterhoek &amp; Koffie</span>
                </button>
            </div>
            <div class="photo-item">
                <button
                    type="button"
                    class="photo-frame"
                    data-gallery-trigger
                    data-gallery-src="<?= $this->Url->image('store-interior.jpeg') ?>"
                    data-gallery-alt="Foto van de platenwinkel"
                    data-gallery-caption="In De Winkel"
                    aria-label="Bekijk foto groot: In De Winkel"
                >
                    <img src="<?= $this->Url->image('store-interior.jpeg') ?>"
                         alt="Foto van de platenwinkel"
                         class="photo-img"
                         loading="lazy">
                    <span class="photo-caption">In De Winkel</span>
                </button>
            </div>
            <div class="photo-item">
                <button
                    type="button"
                    class="photo-frame"
                    data-gallery-trigger
                    data-gallery-src="<?= $this->Url->image('store-ambience.jpeg') ?>"
                    data-gallery-alt="Extra sfeerbeeld van 72 Seaside Vinyl"
                    data-gallery-caption="Sfeerbeeld"
                    aria-label="Bekijk foto groot: Sfeerbeeld"
                >
                    <img src="<?= $this->Url->image('store-ambience.jpeg') ?>"
                         alt="Extra sfeerbeeld van 72 Seaside Vinyl"
                         class="photo-img"
                         loading="lazy">
                    <span class="photo-caption">Sfeerbeeld</span>
                </button>
            </div>
        </div>
    </div>
</section>

<div class="gallery-lightbox" data-gallery-lightbox hidden aria-hidden="true">
    <button type="button" class="gallery-lightbox-close" data-gallery-close aria-label="Sluit fotoviewer">
        <i class="fa-light fa-xmark" aria-hidden="true"></i>
    </button>
    <button type="button" class="gallery-lightbox-nav gallery-lightbox-prev" data-gallery-prev aria-label="Vorige foto">
        <i class="fa-light fa-chevron-left" aria-hidden="true"></i>
    </button>
    <figure class="gallery-lightbox-figure">
        <img src="" alt="" class="gallery-lightbox-image" data-gallery-image>
        <figcaption class="gallery-lightbox-caption" data-gallery-caption></figcaption>
    </figure>
    <button type="button" class="gallery-lightbox-nav gallery-lightbox-next" data-gallery-next aria-label="Volgende foto">
        <i class="fa-light fa-chevron-right" aria-hidden="true"></i>
    </button>
</div>

<!-- ============================================================
     LATEST RELEASES SECTION
     ============================================================ -->
<section class="releases" id="releases">
    <div class="container">
        <div class="section-header">
            <h2>New Releases</h2>
            <div class="section-divider"></div>
            <p class="section-intro">Bekijk onze meest recente aanwinsten &mdash; vers van de pers en klaar om gedraaid te worden.</p>
        </div>
        <div class="releases-grid">
            <?php foreach ($latestReleases as $release) : ?>
            <div class="release-card">
                <div class="release-cover" style="background-color: <?= h($release['color']) ?>;">
                    <?php if (!empty($release['cover'])) : ?>
                    <img
                        src="<?= $this->Url->image('covers/' . $release['cover']) ?>"
                        alt="<?= h($release['artist']) ?> - <?= h($release['title']) ?>"
                        class="release-cover-img"
                        loading="lazy"
                    >
                    <?php else : ?>
                    <div class="record-visual">
                        <div class="record-label"><?= h($release['label_text']) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="release-info">
                    <h4 class="release-title"><?= h($release['title']) ?></h4>
                    <p class="release-artist"><?= h($release['artist']) ?></p>
                    <?php if (!empty($release['genre'])) : ?>
                    <p class="release-genre"><?= h($release['genre']) ?></p>
                    <?php endif; ?>
                    <p class="release-price">&euro; <?= h($release['price']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="releases-cta">
            <p>Kom langs in de winkel voor het volledige assortiment!</p>
        </div>
    </div>
</section>

<!-- ============================================================
     CONTACT & ADDRESS SECTION
     ============================================================ -->
<section class="contact" id="contact">
    <div class="container">
        <div class="section-header">
            <h2>Contact &amp; Adres</h2>
            <div class="section-divider"></div>
        </div>
        <div class="contact-content">
            <div class="contact-info">
                <div class="contact-block">
                    <h3><i class="fa-solid fa-location-dot contact-icon" aria-hidden="true"></i> Adres</h3>
                    <address>
                        <strong>72 Seaside Vinyl</strong><br>
                        Sint Domusstraat 17<br>
                        4301 CP Zierikzee<br>
                        Zeeland, Nederland
                    </address>
                </div>
                <div class="contact-block">
                    <h3><i class="fa-solid fa-clock contact-icon" aria-hidden="true"></i> Openingstijden</h3>
                    <table class="hours-table">
                        <tr><td>Maandag</td><td>Gesloten</td></tr>
                        <tr><td>Dinsdag &ndash; Vrijdag</td><td>10:00 &ndash; 18:00</td></tr>
                        <tr><td>Zaterdag</td><td>10:00 &ndash; 17:00</td></tr>
                        <tr><td>Zondag</td><td>12:00 &ndash; 16:00</td></tr>
                    </table>
                </div>
                <div class="contact-block">
                    <h3><i class="fa-solid fa-phone contact-icon" aria-hidden="true"></i> Bereikbaarheid</h3>
                    <p>
                        <strong>Telefoon:</strong> <a href="tel:+31111000000">+31 (0)111 00 00 00</a><br>
                        <strong>E-mail:</strong> <a href="mailto:info@72seasidevinyl.nl">info@72seasidevinyl.nl</a>
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Instagram"><i class="fa-brands fa-instagram contact-icon" aria-hidden="true"></i> Instagram</a>
                        <a href="#" class="social-link" aria-label="Facebook"><i class="fa-brands fa-facebook contact-icon" aria-hidden="true"></i> Facebook</a>
                    </div>
                </div>
            </div>
            <div class="contact-map">
                <div class="map-placeholder">
                    <p><i class="fa-solid fa-map-location-dot" aria-hidden="true"></i></p>
                    <p><strong>Zierikzee</strong></p>
                    <p>Sint Domusstraat 17</p>
                    <p><small>Kaart volgt binnenkort</small></p>
                </div>
            </div>
        </div>
    </div>
</section>
