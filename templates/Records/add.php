<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Record $record
 */

$this->assign('title', 'Add Record');
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
        <h3 class="font-medium text-body-dark">Scan, Select, Save</h3>
    </div>
    <div class="p-7">
        <?= $this->Form->create($record, [
            'class' => 'space-y-6',
            'url' => [
                'prefix' => false,
                'controller' => 'Records',
                'action' => 'add',
            ],
        ]) ?>

        <div class="w-full rounded border border-stroke bg-gray-1 p-4">
            <p class="mb-2 text-sm font-medium text-body-dark">Barcode lookup</p>
            <div class="flex gap-2">
                <input type="text" id="barcode-input" placeholder="Scan or type barcode…" inputmode="numeric"
                       class="flex-1 rounded border border-stroke bg-white px-4 py-2.5 text-sm text-body-dark outline-none focus:border-primary">
                <button type="button" id="barcode-search-btn"
                        data-url="<?= $this->Url->build(['action' => 'findByBarcode']) ?>"
                        data-details-url="<?= $this->Url->build(['action' => 'discogsReleaseDetails']) ?>"
                        class="inline-flex items-center gap-2 rounded bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-opacity-90 disabled:cursor-not-allowed disabled:opacity-70">
                    <i class="fa-solid fa-barcode"></i> Search
                </button>
            </div>
            <p id="barcode-status" class="mt-1.5 hidden text-sm"></p>
            <div id="barcode-results" class="mt-3 hidden rounded border border-stroke bg-white p-3 text-sm text-body-dark"></div>
            <p id="selected-release-label" class="mt-3 hidden text-sm font-medium text-success"></p>
            <div id="pricing-panel" class="mt-3 hidden rounded border border-stroke bg-white p-3">
                <p class="text-sm text-body-dark">Discogs lowest price: <span id="lowest-price-value" class="font-medium">-</span></p>
                <div class="mt-2">
                    <label for="sale-price-input" class="mb-1 block text-sm font-medium text-body-dark">Sale price (EUR)</label>
                    <input type="number" id="sale-price-input" name="sale_price" min="0" step="0.01" placeholder="0.00"
                           class="w-full rounded border border-stroke bg-gray-1 px-4 py-2.5 text-sm text-body-dark outline-none focus:border-primary">
                </div>
            </div>
        </div>
        <?= $this->Form->hidden('barcode', ['id' => 'record-barcode-hidden']) ?>
        <?= $this->Form->hidden('discogs_release_id', ['id' => 'discogs-release-id']) ?>
        <input type="hidden" name="lowest_price" id="discogs-lowest-price-hidden">
        <input type="hidden" name="discogs_release_payload" id="discogs-release-payload">

        <div class="flex items-center gap-4 border-t border-stroke pt-4">
            <?= $this->Form->button('Save Record', [
                'id' => 'save-record-btn',
                'disabled' => true,
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

    var barcodeInput = document.getElementById('barcode-input');
    var barcodeBtn = document.getElementById('barcode-search-btn');
    var barcodeStatus = document.getElementById('barcode-status');
    var barcodeResults = document.getElementById('barcode-results');
    var selectedReleaseLabel = document.getElementById('selected-release-label');
    var pricingPanel = document.getElementById('pricing-panel');
    var lowestPriceValue = document.getElementById('lowest-price-value');
    var salePriceInput = document.getElementById('sale-price-input');
    var barcodeHidden = document.getElementById('record-barcode-hidden');
    var releaseIdHidden = document.getElementById('discogs-release-id');
    var lowestPriceHidden = document.getElementById('discogs-lowest-price-hidden');
    var releasePayloadHidden = document.getElementById('discogs-release-payload');
    var saveButton = document.getElementById('save-record-btn');

    if (!barcodeInput || !barcodeBtn || !barcodeStatus || !barcodeResults || !barcodeHidden || !releaseIdHidden || !lowestPriceHidden || !releasePayloadHidden || !saveButton || !selectedReleaseLabel || !pricingPanel || !lowestPriceValue || !salePriceInput) {
        return;
    }

    var activeResultButton = null;

    var setPendingSelectionState = function () {
        saveButton.disabled = true;
        selectedReleaseLabel.classList.add('hidden');
        pricingPanel.classList.add('hidden');
        lowestPriceValue.textContent = '-';
        lowestPriceHidden.value = '';
        salePriceInput.value = '';
        releaseIdHidden.value = '';
        releasePayloadHidden.value = '';
        if (activeResultButton) {
            activeResultButton.classList.remove('bg-gray-1');
            activeResultButton = null;
        }
    };

    var runBarcodeSearch = function () {
        var barcode = barcodeInput.value.trim();
        if (!barcode) {
            barcodeStatus.textContent = 'Enter or scan a barcode first.';
            barcodeStatus.className = 'mt-1.5 text-sm text-danger';
            barcodeStatus.classList.remove('hidden');
            return;
        }

        barcodeHidden.value = barcode;
        setPendingSelectionState();

        var baseUrl = barcodeBtn.getAttribute('data-url') || '';
        var url = baseUrl + '?barcode=' + encodeURIComponent(barcode);

        barcodeBtn.disabled = true;
        barcodeStatus.textContent = 'Searching Discogs...';
        barcodeStatus.className = 'mt-1.5 text-sm text-gray-4';
        barcodeStatus.classList.remove('hidden');
        barcodeResults.classList.add('hidden');

        fetchJson(url)
            .then(function (result) {
                if (!result.ok || !result.data.success) {
                    var msg = result.data && result.data.message ? result.data.message : 'Discogs request failed.';
                    throw new Error(msg);
                }

                var items = Array.isArray(result.data.results) ? result.data.results : [];
                barcodeStatus.textContent = items.length + ' result(s) found for barcode ' + barcode + '. Click one to enable save.';
                barcodeStatus.className = 'mt-1.5 text-sm text-success';

                if (items.length === 0) {
                    barcodeResults.innerHTML = '<p class="text-gray-4">No matches found for this barcode.</p>';
                    barcodeResults.classList.remove('hidden');
                    return;
                }

                var listHtml = items.map(function (item) {
                    var title = item.title ? escapeHtml(item.title) : 'Untitled release';
                    var id = item.id ? String(item.id) : '';
                    var year = item.year ? String(item.year) : '-';
                    var country = item.country ? String(item.country) : '-';
                    var catno = item.catno ? String(item.catno) : '-';
                    var lowestPrice = item.lowest_price !== null && item.lowest_price !== undefined ? String(item.lowest_price) : '-';
                    var labels = asList(item.label).slice(0, 2).join(', ') || '-';
                    var formats = asList(item.format).join(' / ') || '-';
                    var imageUrl = item.cover_image ? String(item.cover_image) : (item.thumb ? String(item.thumb) : '');
                    var imageHtml = imageUrl
                        ? '<img src="' + escapeHtml(imageUrl) + '" alt="' + title + '" class="rounded border border-stroke object-cover" style="width:56px;height:56px;min-width:56px;max-width:56px;max-height:56px;object-fit:cover;" loading="lazy">'
                        : '<div class="flex items-center justify-center rounded border border-stroke bg-gray-1 text-[10px] text-gray-4" style="width:56px;height:56px;min-width:56px;max-width:56px;max-height:56px;">No image</div>';

                    return '<li class="border-b border-stroke py-3 last:border-b-0">'
                        + '<button type="button" class="barcode-result-item w-full rounded p-1 text-left transition hover:bg-gray-1" data-release-id="' + escapeHtml(id) + '" data-lowest-price="' + escapeHtml(lowestPrice) + '">'
                        + '<div class="flex items-start gap-3">'
                        + imageHtml
                        + '<div class="min-w-0 flex-1">'
                        + '<div class="font-medium text-primary hover:underline">' + title + '</div>'
                        + '<div class="mt-1 text-xs text-body-dark">ID: ' + escapeHtml(id) + ' | Year: ' + escapeHtml(year) + ' | Country: ' + escapeHtml(country) + '</div>'
                        + '<div class="mt-1 text-xs text-body-dark">Label: ' + escapeHtml(labels) + ' | Cat#: ' + escapeHtml(catno) + '</div>'
                        + '<div class="mt-1 text-xs text-body-dark">Lowest Price: ' + escapeHtml(lowestPrice) + '</div>'
                        + '<div class="mt-1 text-xs text-gray-4">Format: ' + escapeHtml(formats) + '</div>'
                        + '</div>'
                        + '</div>'
                        + '</button>'
                        + '</li>';
                }).join('');

                barcodeResults.innerHTML = '<p class="mb-2 font-medium">Results</p><ul class="list-none pl-0">' + listHtml + '</ul>';
                barcodeResults.classList.remove('hidden');
            })
            .catch(function (error) {
                barcodeStatus.textContent = error.message;
                barcodeStatus.className = 'mt-1.5 text-sm text-danger';
                barcodeResults.classList.add('hidden');
            })
            .finally(function () {
                barcodeBtn.disabled = false;
            });
    };

    barcodeBtn.addEventListener('click', runBarcodeSearch);

    barcodeInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            runBarcodeSearch();
        }
    });

    var barcodeDebounce = null;
    barcodeInput.addEventListener('input', function () {
        clearTimeout(barcodeDebounce);
        var val = barcodeInput.value.trim();
        if (val.length >= 8) {
            barcodeDebounce = setTimeout(runBarcodeSearch, 300);
        }
    });

    barcodeResults.addEventListener('click', function (event) {
        var target = event.target;
        if (!(target instanceof HTMLElement)) {
            return;
        }

        var releaseButton = target.closest('.barcode-result-item');
        if (!releaseButton) {
            return;
        }

        var releaseId = releaseButton.getAttribute('data-release-id');
        var lowestPrice = releaseButton.getAttribute('data-lowest-price') || '-';
        if (!releaseId) {
            return;
        }

        var detailsBaseUrl = barcodeBtn.getAttribute('data-details-url') || '';
        var detailsUrl = detailsBaseUrl + '?release_id=' + encodeURIComponent(releaseId);

        setPendingSelectionState();
        barcodeStatus.textContent = 'Loading selected release...';
        barcodeStatus.className = 'mt-1.5 text-sm text-gray-4';

        fetchJson(detailsUrl)
            .then(function (result) {
                if (!result.ok || !result.data.success) {
                    var errorMessage = result.data && result.data.message ? result.data.message : 'Unable to load release details.';
                    throw new Error(errorMessage);
                }

                var release = result.data.release || result.data;
                var releaseTitle = release && release.title ? String(release.title) : ('Discogs release #' + releaseId);

                releaseIdHidden.value = String(releaseId);
                releasePayloadHidden.value = JSON.stringify(release);
                saveButton.disabled = false;

                activeResultButton = releaseButton;
                activeResultButton.classList.add('bg-gray-1');

                lowestPriceValue.textContent = lowestPrice;
                lowestPriceHidden.value = lowestPrice === '-' ? '' : lowestPrice;
                pricingPanel.classList.remove('hidden');

                selectedReleaseLabel.textContent = 'Selected: ' + releaseTitle;
                selectedReleaseLabel.classList.remove('hidden');

                barcodeStatus.textContent = 'Release selected. Save is enabled.';
                barcodeStatus.className = 'mt-1.5 text-sm text-success';
            })
            .catch(function (error) {
                barcodeStatus.textContent = error.message;
                barcodeStatus.className = 'mt-1.5 text-sm text-danger';
            });
    });

});
</script>
<?php $this->end(); ?>
