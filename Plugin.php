<?php namespace Nerdauto\Leafmap;

use Backend;
use System\Classes\PluginBase;

/**
 * leafmap Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'leafmap',
            'description' => 'No description provided yet...',
            'author'      => 'nerdauto',
            'icon'        => 'icon-leaf'
        ];
    }
    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'nerdauto\leafmap\Components\Map' => 'map',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'nerdauto.leafmap.some_permission' => [
                'tab' => 'nerdauto.leafmap::lang.permissions.maps.tab',
                'label' => 'nerdauto.leafmap::lang.permissions.maps.label'
            ],
        ];
    }
}
