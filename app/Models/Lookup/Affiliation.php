<?php

namespace SCCatalog\Models\Lookup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Class Affiliation
 */
class Affiliation extends Model
{
    use BlameableTrait;
    use HasSlug;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'opportunity_type_id',
        'order',
        'name',
        'slug',
        'access_control',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'access_control' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
     * @return bool
     */
    public function isAccessControl()
    {
        return $this->access_control;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function opportunityType()
    {
        return $this->belongsTo(\SCCatalog\Models\Lookup\OpportunityType::class, 'opportunity_type_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.lookup.affiliation.edit', $this).'" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.edit').'"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route('admin.lookup.affiliation.destroy', $this).'"
             data-method="delete"
             data-trans-button-cancel="'.__('buttons.general.cancel').'"
             data-trans-button-confirm="'.__('buttons.general.crud.delete').'"
             data-trans-title="'.__('strings.backend.general.are_you_sure').'"
             class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.delete').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group btn-group-sm" role="group" aria-label="Actions">
              '.$this->edit_button.'
              '.$this->delete_button.'
            </div>';
    }

    /**
     * @return string
     */
    public function getAccessControlLabelAttribute()
    {
        if ($this->isAccessControl()) {
            return '<span class="badge badge-success">'.__('labels.general.yes').'</span>';
        }

        return '<span class="badge badge-danger">'.__('labels.general.no').'</span>';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}