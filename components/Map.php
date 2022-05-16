<?php namespace nerdauto\leafmap\Components;

use nerdauto\Leafmap\Models\Maps;
use Cms\Classes\ComponentBase;
use Request;

class Map extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'nerdauto.leafmap::lang.component.name',
            'description' => 'nerdauto.leafmap::lang.component.map.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'map' => [
                'title' => 'nerdauto.leafmap::lang.component.map.title',
                'description' => 'nerdauto.leafmap::lang.component.map.description',
                'type' => 'dropdown',
                'required' => true,
            ],
            'showOnlyObject' => [
                'title' => 'nerdauto.leafmap::lang.component.show_only_object_title',
                'description' => 'nerdauto.leafmap::lang.component.show_only_object.description',
                'type' => 'dropdown',
                'depends' => ['map']
            ],
            'fieldId' => [
                'title' => 'nerdauto.leafmap::lang.component.fieldId.title',
                'description' => 'nerdauto.leafmap::lang.component.fieldId.description',
                'default' => 'map',
                'type' => 'string',
                'required' => true,
            ],
            'height' => [
                'title' => 'nerdauto.leafmap::lang.component.height.title',
                'description' => 'nerdauto.leafmap::lang.component.height.description',
                'default' => '400px',
                'type' => 'string',
                'required' => true,
            ],
            'latitude' => [
                'title' => 'nerdauto.leafmap::lang.component.latitude.title',
                'description' => 'nerdauto.leafmap::lang.component.latitude.description',
                'default' => 0,
                'type' => 'string',
                'required' => true,
            ],
            'longitude' => [
                'title' => 'nerdauto.leafmap::lang.component.longitude.title',
                'description' => 'nerdauto.leafmap::lang.component.longitude.description',
                'default' => 0,
                'type' => 'string',
                'required' => true,
            ],
            'zoom' => [
                'title' => 'nerdauto.leafmap::lang.component.zoom.title',
                'description' => 'nerdauto.leafmap::lang.component.zoom.description',
                'default' => 3,
                'type' => 'string',
                'required' => true,
            ],
            'maxZoom' => [
                'title' => 'nerdauto.leafmap::lang.component.maxZoom.title',
                'description' => 'nerdauto.leafmap::lang.component.maxZoom.description',
                'default' => 5,
                'type' => 'string',
                'required' => true,
            ],
            'scrollWheelZoom' => [
                'title' => 'nerdauto.leafmap::lang.component.scroll_wheel_zoom.title',
                'description' => 'nerdauto.leafmap::lang.component.scroll_wheel_zoom.description',
                'default' => true,
                'type' => 'checkbox',
                'required' => true,
            ]
        ];
    }

    public function getMapOptions()
    {
        return Maps::orderBy('name')->lists('name', 'id');
    }

    public function getShowOnlyObjectOptions()
    {
        $mapId = Request::input('map');
        if ($mapId == null) {
            $firstMap = Maps::orderBy('name')->first();
            if ($firstMap != null) {
                $mapId = $firstMap->id;
            }
        }

        $map = $this->mapQuery()->find($mapId);

        $objects = [trans("nerdauto.leafmap::lang.component.show_only_object.all")];

        if ($map) {
            $objects = array_replace_recursive($objects, $map->objects->lists('name', 'id'));
        }

        return $objects;
    }

    public function onRun()
    {
        $this->page['map'] = $this->map();
        $this->addJs('/plugins/nerdauto/leafmap/assets/leaflet/leaflet.js');
        $this->addCss('/plugins/nerdauto/leafmap/assets/leaflet/leaflet.css');
    }

    public function map()
    {
        $map = $this->mapQuery()->find($this->property('map'));
        $map->fieldId = $this->property('fieldId');
        $map->latitude = $this->property('latitude');
        $map->longitude = $this->property('longitude');
        $map->zoom = $this->property('zoom');
        $map->maxZoom = $this->property('maxZoom');
        $map->scrollWheelZoom = $this->property('scrollWheelZoom');
        $map->height = $this->property('height');

        $showOnlyObject = $this->property('showOnlyObject');

        if($showOnlyObject == null || $showOnlyObject == 0) {
            $map->objectsToDisplay = $map->objects;
        } else {
            $map->objectsToDisplay = $map->objects->filter(function ($object) use ($showOnlyObject) {
                return $showOnlyObject == $object->id;
            });
        }
        return $map;
    }

    protected function mapQuery()
    {
        return Maps::with('objects');
    }
}

