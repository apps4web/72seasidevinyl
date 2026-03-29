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
    <img src="https://github.com/user-attachments/assets/abc62b71-968a-4a70-9063-b47698d9a053"
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
     STORE PHOTOS SECTION
     ============================================================ -->
<section class="store-photos">
    <div class="container">
        <div class="photo-grid">
            <div class="photo-item photo-large">
                <div class="photo-frame">
                    <img src="https://github.com/user-attachments/assets/e0f8dcd3-8329-4f07-b70f-6e36283053f1"
                         alt="Ons assortiment vinyl platen op de schappen"
                         class="photo-img"
                         loading="lazy">
                    <span class="photo-caption">Ons Assortiment</span>
                </div>
            </div>
            <div class="photo-item">
                <div class="photo-frame">
                    <img src="https://github.com/user-attachments/assets/79bb6caf-93ca-4ddc-af05-4c45a535a1b4"
                         alt="De Records sectie met kassabalie"
                         class="photo-img"
                         loading="lazy">
                    <span class="photo-caption">Records</span>
                </div>
            </div>
            <div class="photo-item">
                <div class="photo-frame">
                    <img src="https://github.com/user-attachments/assets/7c354ca9-a7b9-4c2d-902c-1a270bdc87a6"
                         alt="De gezellige koffiehoek en balie"
                         class="photo-img"
                         loading="lazy">
                    <span class="photo-caption">Luisterhoek &amp; Koffie</span>
                </div>
            </div>
            <div class="photo-item">
                <div class="photo-frame">
                    <img src="https://github.com/user-attachments/assets/abc62b71-968a-4a70-9063-b47698d9a053"
                         alt="De buitenkant van 72 Seaside Vinyl in Zierikzee"
                         class="photo-img"
                         loading="lazy">
                    <span class="photo-caption">De Winkel</span>
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
            </div>
            <div class="about-highlights">
                <div class="highlight-card">
                    <span class="highlight-icon">&#9679;</span>
                    <h4>Nieuwe Releases</h4>
                    <p>Altijd de nieuwste platen op voorraad, week na week.</p>
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
     LATEST RELEASES SECTION
     ============================================================ -->
<section class="releases" id="releases">
    <div class="container">
        <div class="section-header">
            <h2>Nieuwste Platen</h2>
            <div class="section-divider"></div>
            <p class="section-intro">Bekijk onze meest recente aanwinsten &mdash; vers van de pers en klaar om gedraaid te worden.</p>
        </div>
        <div class="releases-grid">
            <?php foreach ($latestReleases as $release) : ?>
            <div class="release-card">
                <div class="release-cover" style="background-color: <?= h($release['color']) ?>;">
                    <div class="record-visual">
                        <div class="record-label"><?= h($release['label_text']) ?></div>
                    </div>
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
                    <h3>&#128205; Adres</h3>
                    <address>
                        <strong>72 Seaside Vinyl</strong><br>
                        Havenplein 72<br>
                        4301 AB Zierikzee<br>
                        Zeeland, Nederland
                    </address>
                </div>
                <div class="contact-block">
                    <h3>&#128337; Openingstijden</h3>
                    <table class="hours-table">
                        <tr><td>Maandag</td><td>Gesloten</td></tr>
                        <tr><td>Dinsdag &ndash; Vrijdag</td><td>10:00 &ndash; 18:00</td></tr>
                        <tr><td>Zaterdag</td><td>10:00 &ndash; 17:00</td></tr>
                        <tr><td>Zondag</td><td>12:00 &ndash; 16:00</td></tr>
                    </table>
                </div>
                <div class="contact-block">
                    <h3>&#128222; Bereikbaarheid</h3>
                    <p>
                        <strong>Telefoon:</strong> <a href="tel:+31111000000">+31 (0)111 00 00 00</a><br>
                        <strong>E-mail:</strong> <a href="mailto:info@72seasidevinyl.nl">info@72seasidevinyl.nl</a>
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Instagram">&#9679; Instagram</a>
                        <a href="#" class="social-link" aria-label="Facebook">&#9679; Facebook</a>
                    </div>
                </div>
            </div>
            <div class="contact-map">
                <div class="map-placeholder">
                    <p>&#128205;</p>
                    <p><strong>Zierikzee</strong></p>
                    <p>Havenplein 72</p>
                    <p><small>Kaart volgt binnenkort</small></p>
                </div>
            </div>
        </div>
    </div>
</section>
