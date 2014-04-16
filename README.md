HtSettingsModule
====================
[![Master Branch Build Status](https://api.travis-ci.org/hrevert/HtSettingsModule.svg)](http://travis-ci.org/hrevert/HtSettingsModule)
[![Latest Stable Version](https://poser.pugx.org/hrevert/ht-settings-module/v/stable.png)](https://packagist.org/packages/hrevert/ht-settings-module)
[![Latest Unstable Version](https://poser.pugx.org/hrevert/ht-settings-module/v/unstable.png)](https://packagist.org/packages/hrevert/ht-settings-module)
[![Total Downloads](https://poser.pugx.org/hrevert/ht-settings-module/downloads.png)](https://packagist.org/packages/hrevert/ht-settings-module)

HtSettingsModule is a module for adding settings support to your Zend Framework 2 application.

## Installation
* Add `"hrevert/ht-settings-module": "dev-master"` to composer.json and run `php composer.phar update`
* Register `HtSettingsModule` as module in `config/application.config.php`
* Import the SQL schema located in `vendor/hrevert/ht-settings-module/data/schema-sql`
* Copy the file located in `vendor/hrevert/ht-settings-module/config/ht-settings-module.global.php` to `config/autoload` and change the values as you wish

## Docs
The official documentation of HtSettingsModule is available in the [/docs](/docs) folder.

## Acknowledgements
HtSettingsModule is inspired by [SyliusSettingsBundle](https://github.com/Sylius/SyliusSettingsBundle).
