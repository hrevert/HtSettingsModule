HtSettingsModule Quickstart
==============================
This section of the documentation contains an example to help you quickly understand this module. Suppose, we want to store theme settings which contains properties like font size, font color, background color etc.

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
##### From ServiceManager:

```php
<?php
$settings = new Application\Model\Theme();
$settings->setFontSize(25);
$settings->setFontColor('red');
$settingsManager = $this->getServiceLocator()->get('HtSettingsManager');
$settingsManager->save($settings, 'theme'); // done
```

#### From Controller
```php
$this->settings()->save($settings, 'theme');
```

## Retrieving settings
#### From ServiceManager:
```php
$themeSettings = $this->getServiceLocator()->get('HtSettingsManager')->getSettings('theme');
echo $themeSettings->getFontSize();   // will print 25
echo $themeSettings->getFontColor();   // will print red
```

You can also use `HtSettingsModule\Service\SettingsAbstractFactory` to get settings directly from service manager.

```php
// module.config.php
return [
    'service_manager' => [
        'abstract_factories' => [
            'HtSettingsModule\Service\SettingsAbstractFactory',
        ]
    ]
];
```
So, you can get settings directly from service manager like this:

```php
$themeSettings = $this->getServiceLocator->get('settings.theme');
```

#### From controller:
```php
$themeSettings = $this->settings('theme');
```

#### From view templates:
```php
$themeSettings = $this->settings('theme');
```
