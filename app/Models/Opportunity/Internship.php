<?php

namespace SCCatalog\Models\Opportunity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
// use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class Internship
 */
class Internship extends Model
{
    use Searchable;
    // use RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    public $timestamps = false;

    public $fillable = [
        'degree_program',
        'compensation',
        'responsibilities',
        'qualifications',
        'application_instructions',
        'program_lead',
        'success_story',
        'library_collection',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * All relationships to be touched on model update (touch updated_at).
     *
     * @var array
     */
    protected $touches = [
        'opportunity'
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     **/
    public function opportunity()
    {
        return $this->morphOne(\SCCatalog\Models\Opportunity\Opportunity::class, 'opportunityable');
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
    public function getShowButtonAttribute()
    {
        return '<a href="'.route('admin.opportunity.internship.show', $this->opportunity).'" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.view').'" class="btn btn-info"><i class="fas fa-eye"></i></a>';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.opportunity.internship.edit', $this->opportunity).'" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.edit').'"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route('admin.opportunity.internship.destroy', $this->opportunity).'"
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
              '.$this->show_button.'
              '.$this->edit_button.'
              '.$this->delete_button.'
            </div>';
    }

    /**
     * Get the value used to index the model.
     *
     * @return mixed
     */
     public function getScoutKey()
     {
         return $this->opportunity->id;
     }

    /**
     * Get the published status of this model.
     *
     * @return bool
     */
    public function isPublished()
    {
        if (
            $this->is_hidden === 1 ||
            $this->opportunity->status->slug === 'inactive' ||
            (
                $this->opportunity->listing_start_date !== null &&
                Carbon::parse($this->opportunity->listing_start_date)->greaterThan(Carbon::today())
            ) ||
            (
                $this->opportunity->listing_end_date !== null &&
                Carbon::parse($this->opportunity->listing_end_date)->lessThan(Carbon::today())
            )
        ) {
            return false;
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function shouldBeSearchable()
    {
        return $this->isPublished();
    }

    public function toSearchableArray()
    {
        $internship = array();

        $internship['id']                  = $this->opportunity->id;
        $internship['type']                = 'Internship';
        $internship['name']                = e($this->opportunity->name);
        $internship['publicName']          = e($this->opportunity->public_name);
        $internship['description']         = e($this->opportunity->description);
        $internship['isHidden']            = $this->opportunity->is_hidden;
        $internship['startDate']           = $this->opportunity->start_date;
        $internship['endDate']             = $this->opportunity->end_date;
        $internship['applicationDeadline'] = e($this->opportunity->application_deadline);
        $internship['listingStartDate']    = $this->opportunity->listing_start_date;
        $internship['listingEndDate']      = $this->opportunity->listing_end_date;
        $internship['followerCount']       = $this->opportunity->follower_count;
        $internship['status']              = e($this->opportunity->status->name);
        $internship['organizationName']    = e($this->opportunity->organization->name) ?? '';

        // Index Location Cities
        $internship['locations'] = '';
        foreach ($this->opportunity->addresses as $address) {
            $internship['locations'] .= e($address['city']) . ' ' . e($address['state']);
        }

        // Index Affiliations
        $project['affiliations'] = $this->opportunity->affiliations->map(function ($data) {
            return e($data['name']);
        })->toArray();

        // Index AccessAffiliations
        $project['accessAffiliations'] = $this->opportunity->affiliations->where('access_control', true)->map(function ($data) {
            return [
                'name' => e($data['name']),
                'slug' => e($data['slug']),
            ];
        })->toArray();

        // Index AffiliationIcons
        $project['affiliationIcons'] = $this->opportunity->affiliations->map(function ($data) {
            return [
                'slug'             => e($data['slug']),
                'frontend_fa_icon' => json_decode($data['frontend_fa_icon']),
                'backend_fa_icon'  => json_decode($data['backend_fa_icon']),
                'help_text'        => $data['help_text'],
            ];
        })->toArray();

        // Index Categories names
        $internship['categories'] = $this->opportunity->categories->map(function ($data) {
            return e($data['name']);
        })->toArray();

        // Index Keywords names
        $internship['keywords'] = $this->opportunity->keywords->map(function ($data) {
            return e($data['name']);
        })->toArray();

        return $internship;
    }
}
