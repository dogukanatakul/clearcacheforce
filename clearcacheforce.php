<?php


if (!defined('_PS_VERSION_')) {
    exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

class clearcacheforce extends Module
{
    public function __construct()
    {
        $this->name = 'clearcacheforce';
        $this->tab = 'administration';
        $this->version = '1.0.2';
        $this->author = 'github.com/dogukanatakul';
        $this->displayName = 'Clear Cache [Force]';
        $this->description = 'Automatically clears persistent caches after product and discount updates.';
        $this->ps_versions_compliancy = array('min' => '1.7.7.0', 'max' => _PS_VERSION_);
        $this->need_instance = 0;

        parent::__construct();


    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('actionObjectProductUpdateAfter') &&
            $this->registerHook('actionObjectDiscountUpdateAfter');
    }


    public function hookActionObjectProductUpdateAfter($params)
    {
        $this->clearCache();
        return true;
    }

    public function hookActionObjectDiscountUpdateAfter($params)
    {
        $this->clearCache();
        return true;
    }

    private function clearCache()
    {
        $cache = Cache::getInstance();
        $cache->clear();
        $cache->flush();
    }

}
