<?php

/**
 * Кастомное расширение PHP-шаблонизатора для шаблона Demotractor
 *
 * @package Demotractor
 */
class DemotractorPhpExtension extends ViewPhpExtension
{
    /**
     * @var array Конфигурация шаблона
     */
    protected $config = [];

    /**
     * Конструктор
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadConfig();
    }

    /**
     * Загружает конфигурацию шаблона
     */
    protected function loadConfig()
    {
        $configPath = $this->getTemplatePath() . '/config.ini';
        if (file_exists($configPath)) {
            $this->config = parse_ini_file($configPath, true);
        }
    }

    /**
     * Инициализирует общие переменные шаблона
     *
     * @param array $variables
     */
    public function initializeCommonVariables(&$variables)
    {
        // Добавляем конфигурацию в переменные
        $variables['template_config'] = $this->config;
        
        // Добавляем базовые meta-теги
        if (!isset($variables['meta_title'])) {
            $variables['meta_title'] = $this->getConfigValue('default_meta_title', 'Demotractor Template');
        }
        
        if (!isset($variables['meta_description'])) {
            $variables['meta_description'] = $this->getConfigValue('default_meta_description', '');
        }
        
        if (!isset($variables['meta_keywords'])) {
            $variables['meta_keywords'] = $this->getConfigValue('default_meta_keywords', '');
        }

        // Добавляем текущий URL
        $variables['current_url'] = $this->getCurrentUrl();
        
        // Добавляем информацию о шаблоне
        $variables['template_info'] = [
            'name' => $this->getConfigValue('template_name', 'Demotractor'),
            'version' => $this->getConfigValue('template_version', '1.0.0')
        ];
    }

    /**
     * Получает значение из конфигурации
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getConfigValue($key, $default = null)
    {
        return isset($this->config['demotractor'][$key]) ? $this->config['demotractor'][$key] : $default;
    }

    /**
     * Возвращает текущий URL
     *
     * @return string
     */
    protected function getCurrentUrl()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    /**
     * Форматирует дату в соответствии с настройками сайта
     *
     * @param int|string $timestamp
     * @param string $format
     * @return string
     */
    public function formatDate($timestamp, $format = 'd.m.Y H:i')
    {
        if (is_string($timestamp)) {
            $timestamp = strtotime($timestamp);
        }
        return date($format, $timestamp);
    }

    /**
     * Генерирует URL для ресурсов шаблона
     *
     * @param string $resource
     * @return string
     */
    public function getResourceUrl($resource)
    {
        $templateDir = $this->getTemplateDir();
        return $templateDir . '/assets/' . ltrim($resource, '/');
    }

    /**
     * Проверяет, является ли страница специальной
     *
     * @param string $altName
     * @return bool
     */
    public function isSpecialPage($altName)
    {
        $specialPages = $this->getConfigValue('special_pages', []);
        return in_array($altName, $specialPages);
    }

    /**
     * Получает путь к директории шаблона
     *
     * @return string
     */
    protected function getTemplatePath()
    {
        return dirname(__FILE__, 2);
    }

    /**
     * Получает URL директории шаблона
     *
     * @return string
     */
    protected function getTemplateDir()
    {
        // Это нужно адаптировать под структуру UMI.CMS
        return '/templates/demotractor';
    }
}