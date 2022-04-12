@if($action!=null)
<form action="{{route($action)}}" method="post">
@csrf
@endif
<table id="users-list-datatable" class="table">
    <thead>
        <tr >
            @if($action!=null)
            <th><input type="checkbox" class="form-check-input checkbox" onclick="tumuCheked()" id="tumu"></th>
            @endif
            @foreach ($columns as $column) 
                <th>{{$column}}</th>
            @endforeach
            @if($btns!=null)
                @foreach ($btns as $btn)
                <th>{{$btn['name']}}</th>
                @endforeach
            @endif 

           
        </tr>
    </thead>
    <tbody>
        @if($items!=null)
        @foreach ($items as $item)
        <tr class="{{isset($item->rowClass)?$item->rowClass:''}}">
            @if($action!=null)
            <td>
                @if(isset($item->active) && $item->active==1)
                    <input type="checkbox" name="check[]"  value="{{$item['action']}}" class="form-check-input checkbox"  onclick="disab()" id="">
                @endif
            </td>
            @endif
            @foreach ($rows as $row )
                <td class="{{isset($item['class'])  ? $item['class'] : ''}}">
                    {{strtoupper($item[$row])}}
                </td>
               
            @endforeach
            @if($btns!=null)
            @foreach ($btns as $btn)
                @if($btn['name']=="Detay" || !is_array($item->btn)  )
                <td class="{{isset($item['class'])  ? $item['class'] : ''}}">
                    <a href="{{route($btn['route'],$item['action'])}}" class="btn {{$btn['class']}}">{{$btn['name']}}</a>
                </td>
                @else
                <td>{{$item->btn[1]}}</td>
                @endif 
            @endforeach
         
            @endif 
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
@if($events!=null)
<div class="eylem">
    <div>
        <label for="">Eylem</label><br>
        <select class="form-select"  name="event" id="durum" required onclick="disab()">
            <option >Seçilenler için bir olay seç</option>
             @foreach($events as $event)
            <option value="{{$event['name']}}" >{{$event['value']}}</option>
            @endforeach
    </select>
    </div>
    <input type="submit" name="submit" id="submit" value="Kaydet" disabled class="btn btn-primary mt-2" style="display:none">
</div>
</form>
@endif



@if($action!=null)

@section('page.js')
<script src="{{asset('back/assets/js/form.js')}}" type="text/javascript"></script>
@stop

@endif