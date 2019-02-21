<div class="col">
    <div class="table-responsive">
        <table class="table table-hover">
            @foreach($attachments as $attachment)
                <tr>
                    <th>{{ ucwords($attachment->name)  }}</th>
                    <td><a href="{{ $attachment->getUrl() }}">{{ $attachment->file_name }}</a></td>
                </tr>
            @endforeach
        </table>
    </div>
</div><!--table-responsive-->
