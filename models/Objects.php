<?php namespace nerdauto\Leafmap\Models;

use Model;

class Objects extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['name', 'popup'];

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required',
        'type' => 'in:marker,circle,polygon',
        'position' => 'required',
    ];

    public function beforeValidate() {
        if (!$this->type) {
            $this->rules['type'] = 'required';
            return;
        }

        $regExNumber = '[-+]?[0-9]*\.?[0-9]+';
        $latLang = $regExNumber.', ?'.$regExNumber;

        switch ($this->type) {
            case 'marker' :
            case 'cicle' :
                $this->rules['position'] = 'regex:/^('.$latLang.')$/';
                break;
            case 'polygon' :
                $this->rules['position'] = 'regex:/^(\['.$latLang.'\])(, ?\['.$latLang.'\])*$/';
        }
    }
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defines in the database table.
     */
    public $timestamps = true;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nerdauto_leafmap_objects';
}
