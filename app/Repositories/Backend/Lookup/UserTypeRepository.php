<?php

namespace SCCatalog\Repositories\Backend\Lookup;

use SCCatalog\Models\Lookup\UserType;
use SCCatalog\Repositories\BaseRepository;

/**
 * Class UserTypeRepository
 */
class UserTypeRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserType::class;
    }
}
