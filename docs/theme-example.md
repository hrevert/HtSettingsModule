HtSettingsModule Theme example
==============================
This section of the documentation contains an example to help you to easily use this module in your application. Suppose, we want to store theme settings which contains properties like font size, font color, background color etc.

## Domain Objects
    
First create domain object which represents theme settings:

```php
<?php
namespace Application\Model;

class Theme
{
    protected $fontSize;

    protected $fontColor;
  
    //.. other properties

    public function setFontSize($fontSize)
    {
        $this->fontSize = $fontSize;
    }

    public function getFontSize()
    {
        return $this->fontSize;
    }

    public function setFontColor($fontColor)
    {
        $this->fontColor = $fontColor;
    }

    public function getFontColor()
    {
        return $this->fontColor;
    }

    //.. other methods
}

```

## Configuration

Now, tell HtSettingsModule about our new settings.
```php
<?php
return [
    'ht_settings' => [
        'namespaces' => [
            'theme' => [ // here `theme` is the namespace
                'entity_class' => 'Application\Model\Theme',
                'hydrator' => 'Zend\Stdlib\Hydrator\ClassMethods',
            ]
        ]
    ]
];
```
This is pretty straight forward. Here, `theme` is a namespace. Namespaces allow us to manage multiple category of settings. So, you can handle different settings easily. And, the hydrator is for converting array settings to our domain object, `Application\Model\Theme`.


## Storing data
From ServiceLocatorAware classes:

```php

use HtSettingsModule\Entity\Parameter;

$fontSizeParameter = new Parameter('theme', 'font_size', 25);
$fontColorParameter = new Parameter('theme', 'font_color', 'red');
$mapper = $this->getServiceLocator()->get('HtSettingsModule_SettingsMappers');
$mapper->insertParameter($fontSizeParameter);
$mapper->insertParameter($fontColorParameter);
```

## Retrieving settings
From ServiceLocatorAware classes:
```php
$themeSettings = $this->getServiceLocator()->get('HtSettingsModule\Service\SettingsProvider')->getSettings('theme');
echo $themeSettings->getFontSize();   // will print 25
echo $themeSettings->getFontColor();   // will print red
```
From controller:
```php
$themeSettings = $this->getSettings('theme');
```
From view templates:
```php
$themeSettings = $this->getSettings('theme');
```
