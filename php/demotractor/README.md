# Шаблон Demotractor для UMI.CMS

Современный PHP-шаблон для UMI.CMS с использованием Gulp для сборки ресурсов.

## Структура проекта

```
php/demotractor/
├── index.php                    # Главная точка входа
├── config.ini                   # Конфигурация шаблона
├── gulpfile.js                  # Сборщик ресурсов
├── package.json                 # NPM зависимости
├── classes/                     # Классы расширений
│   └── DemotractorPhpExtension.php
├── templates/                   # PHP шаблоны
│   ├── layout/                  # Основные layout'ы
│   │   ├── layout.php
│   │   ├── header.php
│   │   ├── footer.php
│   │   └── navigation.php
│   ├── modules/                 # Шаблоны модулей
│   └── pages/                   # Шаблоны страниц
└── assets/                      # Ресурсы
    ├── css/                     # Готовые CSS файлы
    ├── scss/                    # SCSS исходники
    └── js/                      # JavaScript файлы
```

## Установка

1. Скопируйте папку `demotractor` в директорию templates вашей UMI.CMS
2. Установите Node.js зависимости:
   ```bash
   cd templates/demotractor
   npm install
   ```
3. Соберите ресурсы:
   ```bash
   npm run build
   ```

## Разработка

### Сборка ресурсов

- `npm run build` - сборка для продакшена
- `npm run dev` - запуск сервера разработки с автоперезагрузкой
- `npm run watch` - отслеживание изменений файлов

### Конфигурация

Основные настройки находятся в файле `config.ini`:

- `css_minify` - минификация CSS
- `js_minify` - минификация JavaScript
- `cache_enabled` - включение кэширования
- `special_pages` - список специальных страниц

### Кастомное расширение

Класс `DemotractorPhpExtension` предоставляет дополнительные методы:

- `getConfigValue($key, $default)` - получение значений из конфигурации
- `formatDate($timestamp, $format)` - форматирование дат
- `getResourceUrl($resource)` - URL ресурсов шаблона
- `isSpecialPage($altName)` - проверка специальных страниц

## Особенности

### Обработка RSS

RSS-запросы обрабатываются отдельно без HTML-шаблонизации:

```php
if ($variables['module'] === 'data' && $variables['method'] === 'rss') {
    $this->macros('data', 'rss');
    exit;
}
```

### Специальные страницы

Страницы с определенными alt-именами могут использовать кастомные шаблоны:

```php
if ($altName === 'market') {
    echo $this->render($variables, 'market');
}
```

### Безопасность

- Проверка существования переменных через `isset()`
- Экранирование вывода через `htmlspecialchars()`
- Валидация входных данных

## Расширение функциональности

### Добавление новых специальных страниц

1. Добавьте alt-имя в `config.ini`:
   ```ini
   special_pages[] = "new_page"
   ```

2. Создайте шаблон в `templates/pages/new_page.php`

3. Обновите логику маршрутизации в `index.php`

### Добавление новых методов в расширение

Расширьте класс `DemotractorPhpExtension` в файле `classes/DemotractorPhpExtension.php`

## Поддержка

При возникновении вопросов создайте issue в репозитории проекта.