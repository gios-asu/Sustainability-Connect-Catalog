@extends('layouts.asu-web-standards')

@section('content')
    <section class="content-header">
        <h1>
            Organization
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($organization, ['route' => ['organizations.update', $organization->id], 'method' => 'patch']) !!}

                        @include('organizations.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
