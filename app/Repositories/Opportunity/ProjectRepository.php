<?php

namespace SCCatalog\Repositories\Opportunity;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use SCCatalog\Exceptions\GeneralException;
use SCCatalog\Events\Backend\Opportunity\ProjectCreated;
use SCCatalog\Events\Backend\Opportunity\ProjectUpdated;
use SCCatalog\Events\Backend\Opportunity\ProjectCloned;
use SCCatalog\Models\Address\Address;
use SCCatalog\Models\Lookup\Affiliation;
use SCCatalog\Models\Opportunity\Project;
use SCCatalog\Repositories\BaseRepository;

/**
 * Class ProjectRepository
 */
class ProjectRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Project::class;
    }

    /**
     * Array of related models to always eager load.
     *
     * @var array
     */
    protected $with = [
        'addresses',
        'notes',
        'status',
        'organization',
        'affiliations',
        'categories',
        'keywords',
    ];

    /**
     * @return mixed
     */
    public function getActiveCount()
    {
        return $this->model
            ->active()
            ->count();
    }

    /**
     * @return mixed
     */
    public function getExpiredCount()
    {
        return $this->model
            ->expired()
            ->count();
    }

    /**
     * @return mixed
     */
    public function getFutureCount()
    {
        return $this->model
            ->future()
            ->count();
    }

    /**
     * @return mixed
     */
    public function getCompletedCount()
    {
        return $this->model
            ->completed()
            ->count();
    }

    /**
     * @return mixed
     */
    public function getPublishedCount()
    {
        return $this->model
            ->published()
            ->count();
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getSearchPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getActivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->active()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int $paged
     * @param string $search
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getExpiredPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->expired()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int $paged
     * @param string $search
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getInvalidOpenPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->invalidOpen()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int $paged
     * @param string $search
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getFuturePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->future()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getAllPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getPublishedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->isPublished()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getArchivedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->archived()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getCompletedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->completed()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getDeletedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->onlyTrashed()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getImportReviewsPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->needsImportReview()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getProposalReviewsPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->proposalNeedsReview()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * Create a new Project record in the database.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function create(array $data)
    {
        if (!empty($data['opportunity_start_at'])) {
            $data['opportunity_start_at'] = Carbon::parse($data['opportunity_start_at']);
        }

        if (!empty($data['opportunity_end_at'])) {
            $data['opportunity_end_at'] = Carbon::parse($data['opportunity_end_at']);
        }

        if (!empty($data['listing_start_at'])) {
            $data['listing_start_at'] = Carbon::parse($data['listing_start_at']);
        }

        if (!empty($data['listing_end_at'])) {
            $data['listing_end_at'] = Carbon::parse($data['listing_end_at']);
        }

        if (!empty($data['application_deadline_at'])) {
            $data['application_deadline_at'] = Carbon::parse($data['application_deadline_at']);
        }

        // If text deadline value is set, that overrides any value in the date field, which is to be set
        // to far-future date for Algolia search purposes.
        if (!empty($data['application_deadline_text'])) {
            $data['application_deadline_at'] = Carbon::create(2030, 12, 31, 23, 59);
        }

        // dd($data);

        return DB::transaction(function () use ($data) {
            $project = $this->model->create($data);

            if ($project) {
                // save Address
                $address = new Address([
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'country' => $data['country'] ?? '',
                    'comment' => $data['comment'] ?? '',
                ]);

                $project->addresses()->save($address);

                // attach Affiliations
                if (isset($data['affiliations'])) {
                    foreach ($data['affiliations'] as $affiliation) {
                        $project->affiliations()->attach($affiliation);
                    }
                }

                // attach Categories
                if (isset($data['categories'])) {
                    foreach ($data['categories'] as $category) {
                        $project->categories()->attach($category);
                    }
                }

                // attach Keywords
                if (isset($data['keywords'])) {
                    foreach ($data['keywords'] as $keyword) {
                        $project->keywords()->attach($keyword);
                    }
                }

                event(new ProjectCreated($project));

                return $project;
            }

            throw new GeneralException(__('exceptions.backend.opportunity.create_error'));
        });
    }

    /**
     * Create a new Project record in the database.
     *
     * @param Project $project
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function update(Project $project, array $data)
    {
        $project->loadMissing(
            'addresses',
            'affiliations',
            'categories',
            'keywords'
        );

        if (!empty($data['opportunity_start_at'])) {
            $data['opportunity_start_at'] = Carbon::parse($data['opportunity_start_at']);
        }

        if (!empty($data['opportunity_end_at'])) {
            $data['opportunity_end_at'] = Carbon::parse($data['opportunity_end_at']);
        }

        if (!empty($data['listing_start_at'])) {
            $data['listing_start_at'] = Carbon::parse($data['listing_start_at']);
        }

        if (!empty($data['listing_end_at'])) {
            $data['listing_end_at'] = Carbon::parse($data['listing_end_at']);
        }

        if (!empty($data['application_deadline_at'])) {
            $data['application_deadline_at'] = Carbon::parse($data['application_deadline_at']);
        }

        // If text deadline value is set, that overrides any value in the date field, which is to be set
        // to far-future date for Algolia search purposes.
        if (!empty($data['application_deadline_text'])) {
            $data['application_deadline_at'] = Carbon::create(2030, 12, 31, 23, 59);
        }

        // dd(count($project->addresses));

        return DB::transaction(function () use ($project, $data) {
            if ($project->update($data)) {
                // save Address
                if (isset($data['city'])) {
                    if (0 < count($project->addresses)) {
                        $project->addresses()->first()->update([
                            'city' => $data['city'],
                            'state' => $data['state'],
                            'country' => $data['country'] ?? '',
                            'comment' => $data['comment'] ?? '',
                        ]);
                    } else {
                        $address = new Address([
                            'city' => $data['city'],
                            'state' => $data['state'],
                            'country' => $data['country'] ?? '',
                            'comment' => $data['comment'] ?? '',
                        ]);

                        $project->addresses()->save($address);
                    }
                }

                if (isset($data['file_attachment'])) {
                    $project->addMedia($data['file_attachment'])
                        // ->sanitizingFileName(function($fileName) {
                        //     return strtolower(str_replace(['#', '/', '\\', ' ', ',', ';', '!'], '-', $fileName));
                        // })
                        ->withCustomProperties([
                            // 'type'       => $old_file->type,
                            // 'visibility' => $old_file->visibility,
                            'pending' => 1,
                            'deleted' => 0,
                        ])
                        ->toMediaCollection();
                }

                // sync Affiliations
                $project->affiliations()->sync(array_filter($data['affiliations'] ?? []) ?? null);

                // sync Categories
                $project->categories()->sync(array_filter($data['categories'] ?? []) ?? null);

                // sync Keywords
                $project->keywords()->sync(array_filter($data['keywords'] ?? []) ?? null);

                event(new ProjectUpdated($project));

                return $project;
            }

            throw new GeneralException(__('exceptions.backend.opportunity.update_error'));
        });
    }

    /**
     * Clone opportunity.
     *
     * @param Project $project
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function clone(Project $project)
    {
        return DB::transaction(function () use ($project) {
            $project->load(
                'affiliations',
                'categories',
                'keywords',
                'organization',
                'users',
                'addresses',
                'notes'
            );

            // Copy attributes of original base model
            $clone = $project->replicate();

            // dd($clone);

            // save model before recreating the relations
            $clone->push();

            // dd($clone);

            // reset relations on the original model to control how we replicate them
            // $project->relations = [];

            // load the relations to replicate (clone the associated models)
            // $project->load(
            //     'addresses',
            //     'notes'
            // );

            // dd($project->getRelations());

            // replicate associated models
            // foreach($project->getRelations() as $relation => $items){
            //     if (null !== $items) {
            //         foreach($items as $item){
            //             unset($item->id);
            //             $clone->{$relation}()->create($item->toArray());
            //         }
            //     }
            // }

            // $project->relations = [];

            // load the relations we want re-attach (to associated models)
            // $project->load(
            //     'affiliations',
            //     'categories',
            //     'keywords',
            //     'organizations',
            //     'users'
            // );

            // attach associated models
            // foreach($project->getRelations() as $relation => $items){
            //     foreach($items as $item){
            //         $clone->{$relation}->attach($item->id);
            //     }
            // }

            if ($clone) {
                event(new ProjectCloned($clone));

                return $clone;
            }

            throw new GeneralException(__('exceptions.backend.opportunity.clone_error'));
        });
    }

    /**
     * (Soft)-delete an Project record in the database.
     *
     * @param int $project_id
     * @return bool
     * @throws \Throwable
     */
    public function deleteById($project_id): bool
    {
        return DB::transaction(function () use ($project_id) {
            $project = parent::getById($project_id);

            if (parent::deleteById($project_id)) {

                // event(new ProjectUpdated($project));

                return true;
            }

            throw new GeneralException(__('exceptions.backend.opportunity.destroy_error'));
        });
    }
}
