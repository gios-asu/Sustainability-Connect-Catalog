<?php

namespace SCCatalog\Repositories\Backend\Lookup;

use SCCatalog\Models\Lookup\OpportunityStatus;
use SCCatalog\Repositories\BaseRepository;

/**
 * Class OpportunityStatusRepository
 */
class OpportunityStatusRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return OpportunityStatus::class;
    }
}