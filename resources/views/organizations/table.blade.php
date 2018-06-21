<table class="table table-responsive" id="organizations-table">
    <thead>
        <tr>
            <th>Organization Type Id</th>
        <th>Organization Status Id</th>
        <th>Name</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($organizations as $organization)
        <tr>
            <td>{!! $organization->organization_type_id !!}</td>
            <td>{!! $organization->organization_status_id !!}</td>
            <td>{!! $organization->name !!}</td>
            <td>
                {!! Form::open(['route' => ['organizations.destroy', $organization->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('organizations.show', [$organization->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('organizations.edit', [$organization->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>