<?php
/**
 * Основной layout шаблона Demotractor
 *
 * @var umiTemplaterPHP|ViewPhpExtension|DemotractorPhpExtension $this
 * @var array $variables
 */
?>
<!DOCTYPE html>
<html lang="<?= $this->getConfigValue('language', 'ru') ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <title><?= htmlspecialchars($variables['meta_title'] ?? 'Демонстрационный сайт') ?></title>
    
    <?php if (!empty($variables['meta_description'])): ?>
    <meta name="description" content="<?= htmlspecialchars($variables['meta_description']) ?>">
    <?php endif; ?>
    
    <?php if (!empty($variables['meta_keywords'])): ?>
    <meta name="keywords" content="<?= htmlspecialchars($variables['meta_keywords']) ?>">
    <?php endif; ?>
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?= htmlspecialchars($variables['current_url']) ?>">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= $this->getResourceUrl('css/style.min.css') ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= $this->getResourceUrl('favicon.ico') ?>">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($variables['meta_title'] ?? '') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($variables['meta_description'] ?? '') ?>">
    <meta property="og:url" content="<?= htmlspecialchars($variables['current_url']) ?>">
    <meta property="og:type" content="website">
    
    <!-- Additional head content -->
    <?php if (isset($variables['head_content'])): ?>
        <?= $variables['head_content'] ?>
    <?php endif; ?>
</head>
<body class="<?= isset($variables['body_class']) ? htmlspecialchars($variables['body_class']) : '' ?>">

    <!-- Header -->
    <header class="header">
        <?= $this->render($variables, 'layout/header') ?>
    </header>

    <!-- Main Navigation -->
    <nav class="main-nav">
        <?= $this->render($variables, 'layout/navigation') ?>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <?php if (isset($variables['breadcrumbs'])): ?>
        <div class="breadcrumbs">
            <?= $this->render($variables, 'layout/breadcrumbs') ?>
        </div>
        <?php endif; ?>
        
        <div class="content-wrapper">
            <?= $variables['content'] ?? '' ?>
        </div>
    </main>

    <!-- Sidebar -->
    <?php if (isset($variables['show_sidebar']) && $variables['show_sidebar']): ?>
    <aside class="sidebar">
        <?= $this->render($variables, 'layout/sidebar') ?>
    </aside>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="footer">
        <?= $this->render($variables, 'layout/footer') ?>
    </footer>

    <!-- JavaScript -->
    <script src="<?= $this->getResourceUrl('js/script.min.js') ?>"></script>
    
    <!-- Additional scripts -->
    <?php if (isset($variables['footer_scripts'])): ?>
        <?= $variables['footer_scripts'] ?>
    <?php endif; ?>

    <!-- Template info (only in development mode) -->
    <?php if ($this->getConfigValue('debug_mode', false)): ?>
    <div class="template-debug" style="display: none;">
        <p>Template: <?= htmlspecialchars($variables['template_info']['name']) ?> v<?= htmlspecialchars($variables['template_info']['version']) ?></p>
        <p>Module: <?= htmlspecialchars($variables['module'] ?? 'unknown') ?></p>
        <p>Method: <?= htmlspecialchars($variables['method'] ?? 'unknown') ?></p>
    </div>
    <?php endif; ?>

</body>
</html>