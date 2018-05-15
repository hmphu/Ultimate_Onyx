# Onyx ERP integration Magento 2 module

[![Latest Stable Version](https://poser.pugx.org/ultimate-sa/onyx-magento2/v/stable)](https://packagist.org/packages/ultimate-sa/onyx-magento2)
[![License](https://poser.pugx.org/ultimate-sa/onyx-magento2/license)](https://packagist.org/packages/ultimate-sa/onyx-magento2)
[![Total Downloads](https://poser.pugx.org/ultimate-sa/onyx-magento2/downloads)](https://packagist.org/packages/ultimate-sa/onyx-magento2)

### Requirements

- Magento 2.2.0 Stable or higher
- Enable Single store mode from Magento admin panel

### Setup

Use composer to install this extension, install our module using the following command:

    composer require ultimate-sa/onyx-magento2

Next, install the new module into Magento itself by running this command in Magento base directory:

    php bin/magento module:enable Ultimate_Onyx
    php bin/magento setup:upgrade

Check whether the module is succesfully installed in **Admin > Stores >
Configuration > Advanced > Advanced**.

> Make sure that you have installed Magento cron jobs by this command `php bin/magento cron:install` if not so please run this command as it's critical for synchronization.

### Overview

This module syncs your Magento store with Onyx ERP, modules like Categories, Products and Orders are being synced typically every one hour.

### Usage
