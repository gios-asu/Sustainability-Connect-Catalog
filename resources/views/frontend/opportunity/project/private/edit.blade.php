@extends ('frontend.layouts.coreui')

@section ('title', 'Project | Edit project listing')

@section('content')
{{ html()->form('POST', route('frontend.opportunity.project.private.update', $project))->id('project-form')->class('form-horizontal')->open() }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Full Project Listing
                        <small class="text-muted">Edit project listing</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr />

            @include('frontend.opportunity.project.private.fields')
        </div><!--card-body-->
    </div><!--card-->

{{ html()->form()->close() }}
@endsection
