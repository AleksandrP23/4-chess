<?php
/**
 * Точка входа в шаблон Demotractor.
 *
 * В шаблоне используется:
 *   - Кастомное расширение PHP-шаблонизатора `DemotractorPhpExtension`
 *   - Кастомный файл config.ini
 *   - Сборщик css и js-ресурсов gulp, @see gulpfile.js
 *
 * @var umiTemplaterPHP|ViewPhpExtension|DemotractorPhpExtension $this
 * @var array $variables
 */

// Проверяем наличие необходимых переменных
if (!isset($variables) || !is_array($variables)) {
    throw new Exception('Variables array is required');
}

// Инициализация общих переменных шаблона
$this->initializeCommonVariables($variables);

// Обработка RSS-запросов (прямой вывод в буфер без HTML-шаблонизации)
if (isset($variables['module'], $variables['method']) 
    && $variables['module'] === 'data' 
    && $variables['method'] === 'rss') {
    $this->macros('data', 'rss'); // Макрос неявно прерывает работу скрипта
    exit; // Явное завершение для ясности
}

// Определение страницы и её alt-имени
$pageId = $variables['pageId'] ?? 0;
$page = $pageId ? $this->getPageById($pageId) : null;
$altName = $page ? $page->getAltName() : '';

// Определение шаблона для рендеринга
$templatePath = $this->getTemplatePath($variables, $altName);

// Рендеринг шаблона
echo $this->render($variables, $templatePath);

/**
 * Определяет путь к шаблону на основе переменных и alt-имени страницы
 *
 * @param array $variables
 * @param string $altName
 * @return string
 */
function getTemplatePath($variables, $altName) {
    // Специальные страницы
    $specialPages = [
        'market' => 'market',
        'about' => 'pages/about',
        'contacts' => 'pages/contacts',
        // Добавьте другие специальные страницы здесь
    ];
    
    if (isset($specialPages[$altName])) {
        return $specialPages[$altName];
    }
    
    // Стандартные модули
    $module = $variables['module'] ?? 'content';
    $method = $variables['method'] ?? 'view';
    
    return "{$module}/{$method}";
}
?>