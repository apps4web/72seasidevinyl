<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Record $record
 * @var \Cake\Collection\CollectionInterface|string[] $artists
 * @var \Cake\Collection\CollectionInterface|string[] $genres
 */

$this->assign('title', 'Add Record');

echo $this->Html->css('tom-select', ['block' => 'css']);
$this->Html->script('tom-select.complete.min', ['block' => 'scriptBottom']);
?>
<div class="mb-6">
    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="inline-flex items-center gap-2 text-sm text-gray-4 hover:text-primary">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Records
    </a>
    <div class="mt-3">
        <h1 class="text-2xl font-bold text-body-dark">Add New Record</h1>
        <p class="mt-1 text-sm text-gray-4">Add a new record to your catalogue</p>
    </div>
</div>

<div class="rounded-sm border border-stroke bg-white shadow-default">
    <div class="border-b border-stroke px-7 py-4">
        <h3 class="font-medium text-body-dark">Record Information</h3>
    </div>
    <div class="p-7">
        <?= $this->Form->create($record, ['class' => 'space-y-6', 'type' => 'file']) ?>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <div class="mb-2.5 flex items-center justify-between">
                    <label class="text-sm font-medium text-body-dark">Artist <span class="text-danger">*</span></label>
                    <button type="button" id="toggle-add-artist" class="text-xs text-primary hover:underline">+ New artist</button>
                </div>
                <?= $this->Form->control('artist_id', [
                    'label' => false,
                    'options' => $artists,
                    'empty' => '-- Select Artist --',
                    'id' => 'record-artist-id',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary' . ($record->getError('artist_id') ? ' border-danger' : ''),
                ]) ?>
                <div id="add-artist-panel" class="mt-2 hidden rounded border border-stroke bg-gray-1 p-3">
                    <p class="mb-2 text-xs font-medium text-body-dark">New artist name</p>
                    <div class="flex gap-2">
                        <input type="text" id="new-artist-name" placeholder="Artist name"
                               class="flex-1 rounded border border-stroke bg-white px-3 py-2 text-sm text-body-dark outline-none focus:border-primary">
                        <button type="button" id="save-new-artist"
                                data-url="<?= $this->Url->build(['action' => 'quickAddArtist']) ?>"
                                data-csrf="<?= $this->request->getAttribute('csrfToken') ?>"
                                class="rounded bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-opacity-90 disabled:opacity-60">
                            Save
                        </button>
                    </div>
                    <p id="add-artist-error" class="mt-1 hidden text-xs text-danger"></p>
                </div>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Name <span class="text-danger">*</span></label>
                <?= $this->Form->control('name', [
                    'label' => false,
                    'id' => 'record-name',
                    'placeholder' => 'Record name',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary' . ($record->getError('name') ? ' border-danger' : ''),
                ]) ?>
            </div>

            <div class="sm:col-span-2 w-full rounded border border-stroke bg-gray-1 p-4">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button"
                            id="discogs-search-btn"
                            data-url="<?= $this->Url->build(['action' => 'findLpsByArtistAndAlbum']) ?>"
                            data-details-url="<?= $this->Url->build(['action' => 'discogsReleaseDetails']) ?>"
                            class="inline-flex items-center gap-2 rounded bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-opacity-90 disabled:cursor-not-allowed disabled:opacity-70">
                        Find LPs on Discogs
                    </button>
                    <span id="discogs-search-status" class="text-sm text-gray-4"></span>
                </div>
                <div id="discogs-search-results" class="mt-3 hidden rounded border border-stroke bg-white p-3 text-sm text-body-dark"></div>
                <div id="discogs-pagination" class="mt-3 hidden items-center justify-between gap-3 rounded border border-stroke bg-white p-3 text-sm">
                    <button type="button" id="discogs-prev-page" class="rounded border border-stroke px-3 py-1.5 text-body-dark hover:bg-gray-1 disabled:cursor-not-allowed disabled:opacity-60">Previous</button>
                    <span id="discogs-page-info" class="text-body-dark">Page 1 of 1</span>
                    <button type="button" id="discogs-next-page" class="rounded border border-stroke px-3 py-1.5 text-body-dark hover:bg-gray-1 disabled:cursor-not-allowed disabled:opacity-60">Next</button>
                </div>
                <div id="discogs-release-details-wrap" class="mt-3 hidden rounded border border-stroke bg-white p-3">
                    <p class="mb-2 text-sm font-medium text-body-dark">Discogs full release data</p>
                    <pre id="discogs-release-details" class="max-h-80 overflow-auto rounded bg-gray-1 p-3 text-xs text-body-dark"></pre>
                </div>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Price (EUR)</label>
                <?= $this->Form->control('price', [
                    'label' => false,
                    'type' => 'number',
                    'step' => '0.01',
                    'min' => '0',
                    'placeholder' => '0.00',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary',
                ]) ?>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Release Date</label>
                <?= $this->Form->control('released', [
                    'label' => false,
                    'type' => 'date',
                    'empty' => true,
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary',
                ]) ?>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Cover Image</label>
                <?= $this->Form->control('cover_upload', [
                    'type' => 'file',
                    'label' => false,
                    'accept' => 'image/*',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm text-body-dark outline-none transition focus:border-primary active:border-primary',
                ]) ?>
                <p class="mt-1 text-xs text-gray-4">Upload jpg, jpeg, png, webp, or gif (max 5MB).</p>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Label Text</label>
                <?= $this->Form->control('label_text', [
                    'label' => false,
                    'placeholder' => 'LP, 2xLP, EP',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary',
                ]) ?>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Color</label>
                <div class="flex items-center gap-3">
                    <?= $this->Form->control('color', [
                        'label' => false,
                        'type' => 'color',
                        'class' => 'h-12 w-16 cursor-pointer rounded border border-stroke p-1',
                    ]) ?>
                    <span class="text-sm text-gray-4">Display color for this record</span>
                </div>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Genres</label>
                <?= $this->Form->control('genres._ids', [
                    'label' => false,
                    'options' => $genres,
                    'multiple' => true,
                    'id' => 'genres-select-add',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm text-body-dark outline-none transition focus:border-primary active:border-primary',
                ]) ?>
            </div>
        </div>

        <div class="flex items-center gap-8">
            <div class="relative">
                <?= $this->Form->control('is_latest', [
                    'type' => 'checkbox',
                    'label' => false,
                    'class' => 'sr-only peer',
                    'id' => 'is_latest',
                ]) ?>
                <label for="is_latest" class="flex cursor-pointer items-center gap-3 text-sm font-medium text-body-dark">
                    <div class="relative h-5 w-10 rounded-full bg-gray-3 transition-colors duration-300 after:absolute after:left-0.5 after:top-0.5 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-5"></div>
                    Latest Release
                </label>
            </div>

            <div class="relative">
                <?= $this->Form->control('in_stock', [
                    'type' => 'checkbox',
                    'label' => false,
                    'class' => 'sr-only peer',
                    'id' => 'in_stock',
                    'checked' => true,
                ]) ?>
                <label for="in_stock" class="flex cursor-pointer items-center gap-3 text-sm font-medium text-body-dark">
                    <div class="relative h-5 w-10 rounded-full bg-gray-3 transition-colors duration-300 after:absolute after:left-0.5 after:top-0.5 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-5"></div>
                    In Stock
                </label>
            </div>
        </div>

        <div class="flex items-center gap-4 border-t border-stroke pt-4">
            <?= $this->Form->button('Save Record', [
                'class' => 'inline-flex cursor-pointer items-center gap-2 rounded bg-primary px-8 py-3 text-sm font-medium text-white hover:bg-opacity-90',
            ]) ?>
            <a href="<?= $this->Url->build(['action' => 'index']) ?>"
               class="inline-flex items-center gap-2 rounded border border-stroke px-8 py-3 text-sm font-medium text-body-dark hover:bg-gray-2">
                Cancel
            </a>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<?php $this->append('scriptBottom'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var genresSelect = document.getElementById('genres-select-add');
    if (genresSelect && !genresSelect.tomselect) {
        new TomSelect(genresSelect, {
            plugins: ['remove_button'],
            create: false,
            placeholder: 'Type to search genres...',
            maxOptions: 500,
        });
    }

    var toggleAddArtist = document.getElementById('toggle-add-artist');
    var addArtistPanel = document.getElementById('add-artist-panel');
    var newArtistName = document.getElementById('new-artist-name');
    var saveNewArtist = document.getElementById('save-new-artist');
    var addArtistError = document.getElementById('add-artist-error');

    if (toggleAddArtist && addArtistPanel && newArtistName && saveNewArtist && addArtistError) {
        toggleAddArtist.addEventListener('click', function () {
            var hidden = addArtistPanel.classList.toggle('hidden');
            toggleAddArtist.textContent = hidden ? '+ New artist' : '− Cancel';
            if (!hidden) {
                newArtistName.focus();
            }
        });

        saveNewArtist.addEventListener('click', function () {
            var name = newArtistName.value.trim();
            addArtistError.classList.add('hidden');
            if (!name) {
                addArtistError.textContent = 'Name is required.';
                addArtistError.classList.remove('hidden');
                return;
            }

            saveNewArtist.disabled = true;
            var url = saveNewArtist.getAttribute('data-url');
            var csrf = saveNewArtist.getAttribute('data-csrf');
            var body = new FormData();
            body.append('name', name);
            if (csrf) {
                body.append('_csrfToken', csrf);
            }

            fetch(url, { method: 'POST', body: body })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (!data.success) {
                        addArtistError.textContent = data.message || 'Could not save artist.';
                        addArtistError.classList.remove('hidden');
                        return;
                    }
                    var artistSelect = document.getElementById('record-artist-id');
                    var opt = document.createElement('option');
                    opt.value = data.id;
                    opt.textContent = data.name;
                    opt.selected = true;
                    artistSelect.appendChild(opt);
                    artistSelect.value = data.id;
                    newArtistName.value = '';
                    addArtistPanel.classList.add('hidden');
                    toggleAddArtist.textContent = '+ New artist';
                })
                .catch(function () {
                    addArtistError.textContent = 'Request failed.';
                    addArtistError.classList.remove('hidden');
                })
                .finally(function () {
                    saveNewArtist.disabled = false;
                });
        });

        newArtistName.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                saveNewArtist.click();
            }
        });
    }

    var searchButton = document.getElementById('discogs-search-btn');
    var statusEl = document.getElementById('discogs-search-status');
    var resultsEl = document.getElementById('discogs-search-results');
    var paginationEl = document.getElementById('discogs-pagination');
    var prevPageButton = document.getElementById('discogs-prev-page');
    var nextPageButton = document.getElementById('discogs-next-page');
    var pageInfoEl = document.getElementById('discogs-page-info');
    var detailsWrapEl = document.getElementById('discogs-release-details-wrap');
    var detailsEl = document.getElementById('discogs-release-details');
    var artistSelect = document.getElementById('record-artist-id');
    var nameInput = document.getElementById('record-name');

    if (!searchButton || !statusEl || !resultsEl || !paginationEl || !prevPageButton || !nextPageButton || !pageInfoEl || !detailsWrapEl || !detailsEl || !artistSelect || !nameInput) {
        return;
    }

    var searchState = {
        artist: '',
        album: '',
        page: 1,
        pages: 1,
        perPage: 10,
    };

    var escapeHtml = function (value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    };

    var fetchJson = function (url) {
        return fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        }).then(function (response) {
            return response.json().then(function (data) {
                return { ok: response.ok, data: data };
            }).catch(function () {
                return { ok: response.ok, data: {} };
            });
        });
    };

    var renderReleaseDetails = function (releaseData) {
        detailsEl.textContent = JSON.stringify(releaseData, null, 2);
        detailsWrapEl.classList.remove('hidden');
    };

    var asList = function (value) {
        if (!Array.isArray(value)) {
            return [];
        }

        return value
            .map(function (item) {
                return String(item || '').trim();
            })
            .filter(function (item) {
                return item !== '';
            });
    };

    var updatePaginationUi = function () {
        pageInfoEl.textContent = 'Page ' + searchState.page + ' of ' + searchState.pages;
        prevPageButton.disabled = searchState.page <= 1;
        nextPageButton.disabled = searchState.page >= searchState.pages;
        if (searchState.pages > 1) {
            paginationEl.classList.remove('hidden');
            paginationEl.classList.add('flex');
        } else {
            paginationEl.classList.add('hidden');
            paginationEl.classList.remove('flex');
        }
    };

    var runDiscogsSearch = function (page) {
        var artistName = searchState.artist;
        var albumName = searchState.album;

        if (!artistName || !albumName) {
            statusEl.textContent = 'Select an artist and enter a record name first.';
            statusEl.className = 'text-sm text-danger';
            resultsEl.classList.add('hidden');
            paginationEl.classList.add('hidden');
            paginationEl.classList.remove('flex');
            detailsWrapEl.classList.add('hidden');
            return;
        }

        var baseUrl = searchButton.getAttribute('data-url') || '';
        var url = baseUrl
            + '?artist=' + encodeURIComponent(artistName)
            + '&album=' + encodeURIComponent(albumName)
            + '&page=' + encodeURIComponent(String(page))
            + '&per_page=' + encodeURIComponent(String(searchState.perPage));

        searchButton.disabled = true;
        prevPageButton.disabled = true;
        nextPageButton.disabled = true;
        statusEl.textContent = 'Searching Discogs...';
        statusEl.className = 'text-sm text-gray-4';
        resultsEl.classList.add('hidden');
        detailsWrapEl.classList.add('hidden');

        fetchJson(url)
            .then(function (result) {
                if (!result.ok || !result.data.success) {
                    var errorMessage = result.data && result.data.message ? result.data.message : 'Discogs request failed.';
                    throw new Error(errorMessage);
                }

                var items = Array.isArray(result.data.results) ? result.data.results : [];
                var pagination = result.data.pagination || {};
                searchState.page = Math.max(1, parseInt(pagination.page, 10) || page);
                searchState.pages = Math.max(1, parseInt(pagination.pages, 10) || 1);

                statusEl.textContent = items.length + ' LP result(s) found on this page.';
                statusEl.className = 'text-sm text-success';

                if (items.length === 0) {
                    resultsEl.innerHTML = '<p class="text-gray-4">No LP matches found.</p>';
                    resultsEl.classList.remove('hidden');
                    updatePaginationUi();
                    return;
                }

                var listHtml = items.map(function (item) {
                    var title = item.title ? escapeHtml(item.title) : 'Untitled release';
                    var id = item.id ? String(item.id) : '';
                    var year = item.year ? String(item.year) : '-';
                    var country = item.country ? String(item.country) : '-';
                    var catno = item.catno ? String(item.catno) : '-';
                    var lowestPrice = item.lowest_price !== null && item.lowest_price !== undefined ? String(item.lowest_price) : '-';
                    var forSale = item.num_for_sale !== null && item.num_for_sale !== undefined ? String(item.num_for_sale) : '-';
                    var type = item.type ? String(item.type) : '-';
                    var labels = asList(item.label).slice(0, 2).join(', ') || '-';
                    var formats = asList(item.format).join(' / ') || '-';
                    var imageUrl = item.cover_image ? String(item.cover_image) : (item.thumb ? String(item.thumb) : '');
                    var imageHtml = imageUrl
                        ? '<img src="' + escapeHtml(imageUrl) + '" alt="' + title + '" class="rounded border border-stroke object-cover" style="width:56px;height:56px;min-width:56px;max-width:56px;max-height:56px;object-fit:cover;" loading="lazy">'
                        : '<div class="flex items-center justify-center rounded border border-stroke bg-gray-1 text-[10px] text-gray-4" style="width:56px;height:56px;min-width:56px;max-width:56px;max-height:56px;">No image</div>';

                    if (!id) {
                        return '<li class="py-2 border-b border-stroke last:border-b-0"><span class="font-medium">' + title + '</span></li>';
                    }

                    return '<li class="border-b border-stroke py-3 last:border-b-0">'
                        + '<button type="button" class="discogs-result-item w-full text-left" data-release-id="' + escapeHtml(id) + '">'
                        + '<div class="flex items-start gap-3">'
                        + imageHtml
                        + '<div class="min-w-0 flex-1">'
                        + '<div class="font-medium text-primary hover:underline">' + title + '</div>'
                        + '<div class="mt-1 text-xs text-body-dark">ID: ' + escapeHtml(id) + ' | Year: ' + escapeHtml(year) + ' | Country: ' + escapeHtml(country) + '</div>'
                        + '<div class="mt-1 text-xs text-body-dark">Label: ' + escapeHtml(labels) + ' | Cat#: ' + escapeHtml(catno) + '</div>'
                        + '<div class="mt-1 text-xs text-body-dark">Lowest Price: ' + escapeHtml(lowestPrice) + ' | For Sale: ' + escapeHtml(forSale) + '</div>'
                        + '<div class="mt-1 text-xs text-gray-4">Type: ' + escapeHtml(type) + ' | Format: ' + escapeHtml(formats) + '</div>'
                        + '</div>'
                        + '</div>'
                        + '</button>'
                        + '</li>';
                }).join('');

                resultsEl.innerHTML = '<p class="mb-2 font-medium">Top matches (click one for full data)</p><ul class="list-none pl-0">' + listHtml + '</ul>';
                resultsEl.classList.remove('hidden');
                updatePaginationUi();
            })
            .catch(function (error) {
                statusEl.textContent = error.message;
                statusEl.className = 'text-sm text-danger';
                resultsEl.classList.add('hidden');
                paginationEl.classList.add('hidden');
                paginationEl.classList.remove('flex');
                detailsWrapEl.classList.add('hidden');
            })
            .finally(function () {
                searchButton.disabled = false;
                updatePaginationUi();
            });
    };

    searchButton.addEventListener('click', function () {
        var selectedOption = artistSelect.options[artistSelect.selectedIndex] || null;
        var artistName = selectedOption ? selectedOption.text.trim() : '';
        var albumName = nameInput.value.trim();

        if (!artistName || artistName === '-- Select Artist --' || !albumName) {
            statusEl.textContent = 'Select an artist and enter a record name first.';
            statusEl.className = 'text-sm text-danger';
            resultsEl.classList.add('hidden');
            paginationEl.classList.add('hidden');
            paginationEl.classList.remove('flex');
            detailsWrapEl.classList.add('hidden');
            return;
        }

        searchState.artist = artistName;
        searchState.album = albumName;
        searchState.page = 1;
        searchState.pages = 1;
        runDiscogsSearch(1);
    });

    prevPageButton.addEventListener('click', function () {
        if (searchState.page <= 1) {
            return;
        }

        runDiscogsSearch(searchState.page - 1);
    });

    nextPageButton.addEventListener('click', function () {
        if (searchState.page >= searchState.pages) {
            return;
        }

        runDiscogsSearch(searchState.page + 1);
    });

    resultsEl.addEventListener('click', function (event) {
        var target = event.target;
        if (!(target instanceof HTMLElement)) {
            return;
        }

        var releaseButton = target.closest('.discogs-result-item');
        if (!releaseButton) {
            return;
        }

        var releaseId = releaseButton.getAttribute('data-release-id');
        if (!releaseId) {
            return;
        }

        var detailsBaseUrl = searchButton.getAttribute('data-details-url') || '';
        var detailsUrl = detailsBaseUrl + '?release_id=' + encodeURIComponent(releaseId);

        statusEl.textContent = 'Loading full Discogs release data...';
        statusEl.className = 'text-sm text-gray-4';

        fetchJson(detailsUrl)
            .then(function (result) {
                if (!result.ok || !result.data.success) {
                    var errorMessage = result.data && result.data.message ? result.data.message : 'Unable to load release details.';
                    throw new Error(errorMessage);
                }

                renderReleaseDetails(result.data.release || result.data);
                statusEl.textContent = 'Full Discogs data loaded for release #' + releaseId + '.';
                statusEl.className = 'text-sm text-success';
            })
            .catch(function (error) {
                statusEl.textContent = error.message;
                statusEl.className = 'text-sm text-danger';
                detailsWrapEl.classList.add('hidden');
            });
    });
});
</script>
<?php $this->end(); ?>
