<?php
/**
 * HtSettingsModule Configuration
 *
 * If you have a ./config/autoload/ directory set up for your project, you can
 * drop this config file in it and change the values as you wish.
 */

$options = [
    /**
     * Table name
     */
    //'settings_table' => 'settings',

    /**
     * Parameter Model Entity Class
     *
     * Name of Entity class to use. Useful for using your own entity class
     * instead of the default one provided. Default is HtSettingsModule\Entity\Parameter.
     * The entity class should implement HtSettingsModule\Entity\ParameterInterface
     */
     //'parameter_entity_class' => 'HtSettingsModule\Entity\Parameter',

     /**
      * Namespaces are used to categorize group of settings
      * For example, theme can be namespace which contains font-color, font-size etc.
      */
    'namespaces' => [
        /**
        'theme' => [ // here `theme` is the namespace
             *
             * Entity Class for the namespace
             *
             * Name of Entity class to use. Useful for using your own entity class
             * instead of the default one provided. Default is ArrayObject.
             *
             *
            //'entity_class' => 'Application\Model\Theme',

             *
             * Hydrator class to convert settings array to entity
             *
             * Name of Hydrator class to use. Default is Zend\Stdlib\Hydrator\ArraySerializable
             * Must implement Zend\Stdlib\Hydrator\HydratorInterface
             *
            //'hydrator' => 'Zend\Stdlib\Hydrator\ClassMethods',
        ]
        */
    ],
    /**
     * Caching options
     */
    'cache_options' => [
        /**
         * Enable or disable caching of settings
         * Default: false
         * Accepted values: boolean
         */
        'enabled' => true,
        /**
         * Cache adapter
         *
         * Accepted values:
         *  1. Array(for using different adapter for different namespaces)
         *  2. Service Name
         *  3. Class name
         *
         * To use different adapter for different namespaces, this should be in the below format:
         *
         *      'adapter' => [
         *          'namespace1' => 'adapter1',
         *          'namespace2' => 'adapter2',
         *          // .........
         *      ]
         */
        'adapter' => 'Zend\Cache\Storage\Adapter\Memory',

        /**
         * Namespaces whose settings can be cached
         *
         * Default: all
         * If empty, settings of each namespace can be cached
         */
        //'namespaces' => []
    ]

];

/**
 * You do not need to edit below this line
 */
return [
    'ht_settings' => $options
];
