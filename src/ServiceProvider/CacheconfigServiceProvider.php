<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.

 *
 * @package    Composite Config
 * @version    2.0.0
 * @author     Fl Web Design LLC
 * @license    FLWeb PSL
 * @copyright  (c) 2011-2015, Fl Web Design LLC LLC
 * @link       http://flwebdesignservice.com
 */

namespace Abcflorida\Cacheconfig\ServiceProvider;

use Cartalyst\CompositeConfig\Laravel\CompositeConfigServiceProvider;
//use Cartalyst\CompositeConfig\Repository;
use Abcflorida\Cacheconfig\Repository\CacheconfigRepository as Repository;
use Platform\Settings\Providers\SettingsServiceProvider;


class CacheconfigServiceProvider extends CompositeConfigServiceProvider 
{
    
    public function boot () {
        
        
    } 
    
    public function register()
    {
       $this->prepareResources();

       $this->overrideConfigInstance();

       $this->setUpConfig();
    
    }

    /**
     * Overrides the config instance.
     *
     * @return void
     */
    protected function overrideConfigInstance()
    {
        $this->app->register('Illuminate\Cache\CacheServiceProvider');

        $repository = new Repository([], $this->app['cache'] );

        $oldItems = $this->app['config']->all();

        foreach ($oldItems as $key => $value) {
            $repository->set($key, $value);
        }

        $this->app->instance('config', $repository);
    }

    
}
