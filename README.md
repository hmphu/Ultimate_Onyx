# Onyx ERP integration Magento 2 module

[![Latest Stable Version](https://poser.pugx.org/ultimate-eg/onyx-magento2/v/stable)](https://packagist.org/packages/ultimate-eg/onyx-magento2)
[![License](https://poser.pugx.org/ultimate-eg/onyx-magento2/license)](https://packagist.org/packages/ultimate-eg/onyx-magento2)
[![Total Downloads](https://poser.pugx.org/ultimate-eg/onyx-magento2/downloads)](https://packagist.org/packages/ultimate-eg/onyx-magento2)

## Overview

This module syncs your Magento store with Onyx ERP by Ultimate Solutions, modules like Categories, Products, Customers and Orders are being synced typically every one hour. For more info about Onyx ERP please visit: http://www.ultimate-eg.net

### Requirements

- Magento 2.2.\* Stable
- Enable Single store mode from Magento admin panel or you will have to manually assign products to stores.

### Setup

Use composer to install this extension, install our module using the following command:

    composer require ultimate-eg/onyx-magento2

> If any errors are returned after this command, just run `composer update` immediately.

Next, install the new module into Magento itself by running this command in Magento base directory:

    php bin/magento module:enable Ultimate_Onyx
    php bin/magento setup:upgrade
    php bin/magento setup:di:compile

Check whether the module is succesfully installed in **Admin > Stores >
Configuration > Advanced > Advanced**.

> Make sure that you have installed Magento cron jobs by this command `php bin/magento cron:install` if not so please run this command as it's critical for synchronization. If this command returns any errors, please refer to https://devdocs.magento.com/guides/v2.2/config-guide/cli/config-cli-subcommands-cron.html

### Usage

1. First: Set your API settings in **Admin > System > Onyx ERP > API Settings**.
2. Second: Test API by clicking Sync Now button.
3. Finally: Watch all changes done by the module in **Admin > System > Onyx ERP > Sync Log**.
