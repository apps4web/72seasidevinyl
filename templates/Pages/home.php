<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->disableAutoLayout();

$checkConnection = function (string $name) {
    $error = null;
    $connected = false;
    try {
        ConnectionManager::get($name)->getDriver()->connect();
        // No exception means success
        $connected = true;
    } catch (Exception $connectionError) {
        $error = $connectionError->getMessage();
        if (method_exists($connectionError, 'getAttributes')) {
            $attributes = $connectionError->getAttributes();
            if (isset($attributes['message'])) {
                $error .= '<br />' . $attributes['message'];
            }
        }
        if ($name === 'debug_kit') {
            $error = 'Try adding your current <b>top level domain</b> to the
                <a href="https://book.cakephp.org/debugkit/5/en/index.html#configuration" target="_blank">DebugKit.safeTld</a>
            config and reload.';
            if (!in_array('sqlite', \PDO::getAvailableDrivers())) {
                $error .= '<br />You need to install the PHP extension <code>pdo_sqlite</code> so DebugKit can work properly.';
            }
        }
    }

    return compact('connected', 'error');
};

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
    );
endif;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        72 Seaside Vinyl:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('app') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="min-h-screen bg-gray-50 text-gray-900">
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="<?= $this->Url->build('/') ?>" class="text-xl font-bold text-gray-900 hover:text-gray-700">
                        72 Seaside Vinyl
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Welcome to CakePHP <?= h(Configure::version()) ?>
            </h1>
            <p class="mt-2 text-sm text-gray-600">
                Please be aware that this page will not be shown if you turn off debug mode unless you replace
                <code class="bg-gray-100 px-1 rounded">templates/Pages/home.php</code> with your own version.
            </p>
        </div>

        <div id="url-rewriting-warning" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700" style="display:none">
            <p>URL rewriting is not properly configured on your server.</p>
            <ul class="mt-2 list-disc list-inside">
                <li><a target="_blank" rel="noopener" href="https://book.cakephp.org/5/en/installation.html#url-rewriting" class="underline">Help me configure it</a></li>
                <li><a target="_blank" rel="noopener" href="https://book.cakephp.org/5/en/development/configuration.html#general-configuration" class="underline">I don't / can't use URL rewriting</a></li>
            </ul>
        </div>
        <?php Debugger::checkSecurityKeys(); ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h4 class="text-lg font-semibold mb-4">Environment</h4>
                <ul class="space-y-2">
                <?php if (version_compare(PHP_VERSION, '8.1.0', '>=')) : ?>
                    <li class="flex items-center gap-2 text-green-700">
                        <span class="text-green-500">✓</span>
                        Your version of PHP is 8.1.0 or higher (detected <?= PHP_VERSION ?>).
                    </li>
                <?php else : ?>
                    <li class="flex items-center gap-2 text-red-700">
                        <span class="text-red-500">✗</span>
                        Your version of PHP is too low. You need PHP 8.1.0 or higher to use CakePHP (detected <?= PHP_VERSION ?>).
                    </li>
                <?php endif; ?>

                <?php if (extension_loaded('mbstring')) : ?>
                    <li class="flex items-center gap-2 text-green-700"><span class="text-green-500">✓</span> Your version of PHP has the mbstring extension loaded.</li>
                <?php else : ?>
                    <li class="flex items-center gap-2 text-red-700"><span class="text-red-500">✗</span> Your version of PHP does NOT have the mbstring extension loaded.</li>
                <?php endif; ?>

                <?php if (extension_loaded('openssl')) : ?>
                    <li class="flex items-center gap-2 text-green-700"><span class="text-green-500">✓</span> Your version of PHP has the openssl extension loaded.</li>
                <?php else : ?>
                    <li class="flex items-center gap-2 text-red-700"><span class="text-red-500">✗</span> Your version of PHP does NOT have the openssl extension loaded.</li>
                <?php endif; ?>

                <?php if (extension_loaded('intl')) : ?>
                    <li class="flex items-center gap-2 text-green-700"><span class="text-green-500">✓</span> Your version of PHP has the intl extension loaded.</li>
                <?php else : ?>
                    <li class="flex items-center gap-2 text-red-700"><span class="text-red-500">✗</span> Your version of PHP does NOT have the intl extension loaded.</li>
                <?php endif; ?>

                <?php if (ini_get('zend.assertions') !== '1') : ?>
                    <li class="flex items-center gap-2 text-yellow-700"><span class="text-yellow-500">⚠</span> You should set <code>zend.assertions</code> to <code>1</code> in your <code>php.ini</code> for your development environment.</li>
                <?php endif; ?>
                </ul>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h4 class="text-lg font-semibold mb-4">Filesystem</h4>
                <ul class="space-y-2">
                <?php if (is_writable(TMP)) : ?>
                    <li class="flex items-center gap-2 text-green-700"><span class="text-green-500">✓</span> Your tmp directory is writable.</li>
                <?php else : ?>
                    <li class="flex items-center gap-2 text-red-700"><span class="text-red-500">✗</span> Your tmp directory is NOT writable.</li>
                <?php endif; ?>

                <?php if (is_writable(LOGS)) : ?>
                    <li class="flex items-center gap-2 text-green-700"><span class="text-green-500">✓</span> Your logs directory is writable.</li>
                <?php else : ?>
                    <li class="flex items-center gap-2 text-red-700"><span class="text-red-500">✗</span> Your logs directory is NOT writable.</li>
                <?php endif; ?>

                <?php $settings = Cache::getConfig('_cake_translations_'); ?>
                <?php if (!empty($settings)) : ?>
                    <li class="flex items-center gap-2 text-green-700"><span class="text-green-500">✓</span> The <em><?= h($settings['className']) ?></em> is being used for core caching. To change the config edit config/app.php</li>
                <?php else : ?>
                    <li class="flex items-center gap-2 text-red-700"><span class="text-red-500">✗</span> Your cache is NOT working. Please check the settings in config/app.php</li>
                <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h4 class="text-lg font-semibold mb-4">Database</h4>
                <?php
                $result = $checkConnection('default');
                ?>
                <ul class="space-y-2">
                <?php if ($result['connected']) : ?>
                    <li class="flex items-center gap-2 text-green-700"><span class="text-green-500">✓</span> CakePHP is able to connect to the database.</li>
                <?php else : ?>
                    <li class="flex items-center gap-2 text-red-700"><span class="text-red-500">✗</span> CakePHP is NOT able to connect to the database.<br /><?= h($result['error']) ?></li>
                <?php endif; ?>
                </ul>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h4 class="text-lg font-semibold mb-4">DebugKit</h4>
                <ul class="space-y-2">
                <?php if (Plugin::isLoaded('DebugKit')) : ?>
                    <li class="flex items-center gap-2 text-green-700"><span class="text-green-500">✓</span> DebugKit is loaded.</li>
                    <?php
                    $result = $checkConnection('debug_kit');
                    ?>
                    <?php if ($result['connected']) : ?>
                        <li class="flex items-center gap-2 text-green-700"><span class="text-green-500">✓</span> DebugKit can connect to the database.</li>
                    <?php else : ?>
                        <li class="flex items-center gap-2 text-red-700"><span class="text-red-500">✗</span> There are configuration problems present which need to be fixed:<br /><?= $result['error'] ?></li>
                    <?php endif; ?>
                <?php else : ?>
                    <li class="flex items-center gap-2 text-red-700"><span class="text-red-500">✗</span> DebugKit is <strong>not</strong> loaded.</li>
                <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-4">Getting Started</h3>
                <ul class="space-y-2">
                    <li><a target="_blank" rel="noopener" href="https://book.cakephp.org/5/en/" class="text-blue-600 hover:underline">CakePHP Documentation</a></li>
                    <li><a target="_blank" rel="noopener" href="https://book.cakephp.org/5/en/tutorials-and-examples/cms/installation.html" class="text-blue-600 hover:underline">The 20 min CMS Tutorial</a></li>
                </ul>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-4">Help and Bug Reports</h3>
                <ul class="space-y-2">
                    <li><a target="_blank" rel="noopener" href="https://slack-invite.cakephp.org/" class="text-blue-600 hover:underline">Slack</a></li>
                    <li><a target="_blank" rel="noopener" href="https://github.com/cakephp/cakephp/issues" class="text-blue-600 hover:underline">CakePHP Issues</a></li>
                    <li><a target="_blank" rel="noopener" href="https://discourse.cakephp.org/" class="text-blue-600 hover:underline">CakePHP Forum</a></li>
                </ul>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-4">Docs and Downloads</h3>
                <ul class="space-y-2">
                    <li><a target="_blank" rel="noopener" href="https://api.cakephp.org/" class="text-blue-600 hover:underline">CakePHP API</a></li>
                    <li><a target="_blank" rel="noopener" href="https://bakery.cakephp.org" class="text-blue-600 hover:underline">The Bakery</a></li>
                    <li><a target="_blank" rel="noopener" href="https://plugins.cakephp.org" class="text-blue-600 hover:underline">CakePHP plugins repo</a></li>
                    <li><a target="_blank" rel="noopener" href="https://github.com/cakephp/" class="text-blue-600 hover:underline">CakePHP Code</a></li>
                </ul>
            </div>
        </div>
    </main>
    <footer class="bg-white border-t border-gray-200 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-sm text-gray-500">&copy; <?= date('Y') ?> 72 Seaside Vinyl</p>
        </div>
    </footer>
</body>
</html>
