HtSettingsModule
====================
[![Master Branch Build Status](https://api.travis-ci.org/hrevert/HtSettingsModule.svg)](http://travis-ci.org/hrevert/HtSettingsModule)
[![Latest Stable Version](https://poser.pugx.org/hrevert/ht-settings-module/v/stable.png)](https://packagist.org/packages/hrevert/ht-settings-module)
[![Latest Unstable Version](https://poser.pugx.org/hrevert/ht-settings-module/v/unstable.png)](https://packagist.org/packages/hrevert/ht-settings-module)
[![Total Downloads](https://poser.pugx.org/hrevert/ht-settings-module/downloads.png)](https://packagist.org/packages/hrevert/ht-settings-module)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/hrevert/HtSettingsModule/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/hrevert/HtSettingsModule/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/hrevert/HtSettingsModule/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/hrevert/HtSettingsModule/?branch=master)

HtSettingsModule is a module for adding settings support to your Zend Framework 2 application.
This module does not provide any GUI for settings. It just provides a way for easy persistence of application settings.

## Installation
* Add `"hrevert/ht-settings-module": "dev-master"` to composer.json and run `php composer.phar update`
* Register `HtSettingsModule` as module in `config/application.config.php`
* Import the SQL schema located in `vendor/hrevert/ht-settings-module/data/schema.sql`
* Copy the file located in `vendor/hrevert/ht-settings-module/config/ht-settings-module.global.php` to `config/autoload` and change the values as you wish

## Docs
The official documentation of HtSettingsModule is available in the [/docs](/docs) folder.

## Acknowledgements
HtSettingsModule is inspired by [SyliusSettingsBundle](https://github.com/Sylius/SyliusSettingsBundle).
