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
    </div>
</section>

<!-- ============================================================
     INTRO TEASER SECTION
     ============================================================ -->
<section class="intro-teaser" aria-labelledby="intro-teaser-title">
    <div class="container">
        <div class="intro-teaser-card">
            <div class="intro-teaser-content">
                <p class="intro-kicker">Het verhaal achter 72 Seaside Vinyl</p>
                <h2 id="intro-teaser-title">Vinyl met karakter, herinneringen en geluid dat blijft hangen.</h2>
                <p>
                    Na meer dan 20 jaar vinyl verzamelen besloten we onze passie te delen en
                    72 Seaside Vinyl te openen: een plek voor iedereen die houdt van vinylplaten,
                    lp&rsquo;s en muziek met karakter.
                </p>
                <p>
                    In onze winkel kun je rustig snuffelen tussen klassieke albums, nieuwe releases
                    en bijzondere platen. Misschien vind je precies die lp die je terugbrengt naar
                    een festival, vakantie of een mooie herinnering.
                </p>
                <p class="intro-closing">
                    Vinyl is meer dan muziek. Het is de hoes, het geluid en het moment waarop de
                    naald de plaat raakt.
                </p>
                <div class="intro-teaser-cta">
                    <a href="#about" class="btn btn-primary">Lees Meer Over Ons</a>
                </div>
            </div>
        </div>
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
                <p>
                    Bij <strong>72 Seaside Vinyl</strong> willen we dat het voelt als dat kleine,
                    gezellige platenwinkeltje waar je binnenloopt om muziek te ontdekken,
                    verhalen te delen en nieuwe platen te vinden.
                </p>
                <p>
                    Zoek je een specifieke plaat? Laat het ons weten via een "message in a bottle"
                    en we denken graag met je mee in de zoektocht naar dat ene album dat nog
                    ontbreekt in je collectie.
                </p>
                <p>
                    Naast oude klassiekers vind je bij ons ook nieuwe vinyl releases, verhalen
                    achter albums en leuke weetjes over artiesten.
                </p>
                <p>
                    Onze missie is simpel: de liefde voor muziek en vinyl delen.
                    Van doorgewinterde verzamelaars tot de Spotify-generatie die misschien voor
                    het eerst een plaat uit de hoes haalt.
                </p>
                <p>
                    Want eerlijk is eerlijk... er gaat niets boven het geluid van een draaiende plaat.
                </p>
            </div>
            <div class="about-highlights">
                <div class="highlight-card">
                    <span class="highlight-record-wrap" aria-hidden="true">
                        <h4 class="highlight-card-title-behind">New Releases</h4>
                        <span class="highlight-record"><span class="highlight-record-label"></span></span>
                    </span>
                    <p>Always the latest records in stock, week after week.</p>
                </div>
                <div class="highlight-card">
                    <span class="highlight-record-wrap" aria-hidden="true">
                        <h4 class="highlight-card-title-behind">Tweedehands</h4>
                        <span class="highlight-record"><span class="highlight-record-label"></span></span>
                    </span>
                    <p>Een groeiende collectie zorgvuldig geselecteerde tweedehands platen.</p>
                </div>
                <div class="highlight-card">
                    <span class="highlight-record-wrap" aria-hidden="true">
                        <h4 class="highlight-card-title-behind">Advies op Maat</h4>
                        <span class="highlight-record"><span class="highlight-record-label"></span></span>
                    </span>
                    <p>Persoonlijk advies van onze enthousiaste medewerkers.</p>
                </div>
                <div class="highlight-card">
                    <span class="highlight-record-wrap" aria-hidden="true">
                        <h4 class="highlight-card-title-behind">Luisterhoek</h4>
                        <span class="highlight-record"><span class="highlight-record-label"></span></span>
                    </span>
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
            <div class="contact-top">
                <div class="contact-block">
                    <h3><i class="fa-solid fa-envelope contact-icon" aria-hidden="true"></i> Stuur Ons Een Bericht</h3>
                    <?= $this->Form->create(null, [
                        'url' => ['controller' => 'Pages', 'action' => 'contact'],
                        'class' => 'contact-form',
                        'id' => 'contact-form',
                        'novalidate' => true,
                    ]) ?>
                        <div class="contact-form-field">
                            <?= $this->Form->label('name', 'Naam') ?>
                            <?= $this->Form->text('name', [
                                'id' => 'contact-name',
                                'required' => true,
                                'maxlength' => 120,
                                'autocomplete' => 'name',
                            ]) ?>
                        </div>
                        <div class="contact-form-field">
                            <?= $this->Form->label('email', 'E-mail') ?>
                            <?= $this->Form->email('email', [
                                'id' => 'contact-email',
                                'required' => true,
                                'maxlength' => 190,
                                'autocomplete' => 'email',
                            ]) ?>
                        </div>
                        <div class="contact-form-field">
                            <?= $this->Form->label('message', 'Bericht') ?>
                            <?= $this->Form->textarea('message', [
                                'id' => 'contact-message',
                                'required' => true,
                                'maxlength' => 5000,
                                'rows' => 5,
                            ]) ?>
                        </div>
                        <div class="contact-form-honeypot" aria-hidden="true">
                            <?= $this->Form->label('website', 'Laat dit veld leeg') ?>
                            <?= $this->Form->text('website', [
                                'id' => 'contact-website',
                                'tabindex' => '-1',
                                'autocomplete' => 'off',
                            ]) ?>
                        </div>
                        <?= $this->Form->button('Verstuur Bericht', ['class' => 'btn btn-primary contact-submit']) ?>
                    <?= $this->Form->end() ?>
                </div>

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
                            <tr><td>Maandag &ndash; Dinsdag</td><td>Gesloten</td></tr>
                            <tr><td>Woensdag &ndash; Vrijdag</td><td>10:00 &ndash; 18:00</td></tr>
                            <tr><td>Zaterdag</td><td>10:00 &ndash; 17:00</td></tr>
                            <tr><td>Zondag</td><td>12:00 &ndash; 16:00</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="contact-map">
                <iframe
                    title="Google Maps - 72 Seaside Vinyl"
                    class="contact-map-iframe"
                    src="https://www.google.com/maps?daddr=Sint+Domusstraat+17,+4301+CM+Zierikzee&output=embed"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen
                ></iframe>
            </div>
        </div>
    </div>
</section>
