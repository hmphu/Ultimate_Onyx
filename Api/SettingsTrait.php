<?php

namespace Ultimate\Onyx\Api;

use Dotenv\Dotenv;

/**
 * Onyx ERP Settings trait
 */
trait SettingsTrait
{
    public function loadSettings()
    {
        $dotenv = new Dotenv(__DIR__);
        $dotenv->load();
    }

    public function updateSettings($settings = [])
    {
        $this->loadSettings();

        $this->setEnv('API_URL', $this->formUrl($settings['api_url']));
        $this->setEnv('ACCESS_TOKEN', $settings['access_token']);
        $this->setEnv('ACCESS_KEY', $settings['access_key']);
        $this->setEnv('ACTIVITY_NUMBER', $settings['activity_number']);
        $this->setEnv('BRANCH_NUMBER', $settings['branch_number']);
        $this->setEnv('QTY_WITH_RESERVED', $settings['qty']);
        $this->setEnv('IMAGES_URL', $this->formUrl($settings['images_url']));
        $this->setEnv('ACCOUNTING_YEAR', $settings['accounting_year']);
        $this->setEnv('LANGUAGE_ID', $settings['language_id']);
    }

    public function setEnv($key, $value)
    {
        $file = __DIR__ . '/.env';
        $settings = file_get_contents($file);

        $oldValue = getenv($key);

        $settings = str_replace("{$key}={$oldValue}", "{$key}={$value}", $settings);

        $fp = fopen($file, 'w');
        fwrite($fp, $settings);
        fclose($fp);
    }

    public function formUrl($url)
    {
        if (substr($url, -1) == '/') {
            return $url;
        } else {
            return $url . '/';
        }
    }
}
