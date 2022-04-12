@php $status=session()->get('status'); @endphp

@if($status != null)
<div class="alert alert-{{$status[1]}} alert-dismissible fade show" role="alert">
    @if(is_array($status[0]))
        @foreach ($status[0] as $item)
        <div>{!! $item !!}</div>
        @endforeach
    @else
        <div>{!!  $status[0] !!}</div>
    @endif
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif