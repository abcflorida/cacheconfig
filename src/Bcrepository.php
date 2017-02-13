<?php

/**
 * Part of the Abcflorida Overrides fro Cartalyst - Config package.
 *
 * NOTICE OF LICENSE
 *
 *
 * @package    Cacheconfig
 * @version    2.0
 * @author     Flwebdesign LLC
 * @license    MIT
 * @copyright  (c) 2016-2020, Cartalyst LLC
 * @link       http://flwebdesignservice.com
 */

namespace Abcflorida\Cacheconfig\Repository;

use Cartalyst\CompositeConfig\Repository;

class CacheconfigRepository extends Repository
{
            
    public function __construct(array $items = [], CacheManager $cache = null)
    {
        $this->cache = $cache;

        parent::__construct($items);
        
    }        

    /**
     * Cache all configurations.
     *
     * @return void
     */
    public function fetchAndCache()
    {
        $this->removeCache();

        $configs = $this->cache->rememberForever('cartalyst.config', function () {
            return $this->database->table($this->databaseTable)->get();
        });

        $cachedConfigs = [];

        foreach ($configs as $key => $config) {
            $value = $this->parseValue($config->value);

            $item = explode( '.', $config->item );
            
            array_shift( $item );
            
            $item = implode( '.', $item );
            
            $cachedConfigs[$item] = $value;

            parent::set($config->item, $value);
        }

        $this->cachedConfigs = $cachedConfigs;

    }

}
