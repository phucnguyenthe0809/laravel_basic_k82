{{-- {{ $user->info->CMT }} --}}


{{-- {{ $info->users->email }}
{{ $info->users->address }}
{{ $info->users->level }} --}}


@foreach ($cate->product as $row)
    <pre>
            {{ print_r($row->toarray()) }}
    </pre>
    <hr>
@endforeach





