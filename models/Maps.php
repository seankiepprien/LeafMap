<?php namespace nerdauto\Leafmap\Models;

use Model;

class Maps extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required'
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = true;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nerdauto_leaflet_maps';

    public $hasMany = [
        'objects' => ['nerdauto\Leafmap\Models\Objects'],
        'objects_count' => ['nerdauto\LeafMap\Models\Objects', 'count' => true],
    ];

    public function objects() {
        return $this->hasMany('nerdauto\Leafmap\Models\Objects');
    }
}
