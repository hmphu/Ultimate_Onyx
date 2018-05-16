<?php

namespace Ultimate\Onyx\Api;

use Dotenv\Dotenv;

/**
 * Onyx Settings trait
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
        $this->setEnvironmentVariable('API_URL', $settings['API_URL']);
    }

    public function setEnvironmentVariable($key, $value)
    {
        $file = __DIR__ . '/.env';
        $settings = file_get_contents($file);

        $oldValue = getenv($key);

        $settings = str_replace("{$key}={$oldValue}", "{$key}={$value}", $settings);

        $fp = fopen($file, 'w');
        fwrite($fp, $settings);
        fclose($fp);
    }
}
