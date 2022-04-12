<form id="form-add-contact" class="contact-input" action="{{route($form->action)}}" method="{{$form->method}}" 
    @if($form->enctype)         enctype="{{$form->enctype}}"              @endif
>
        @csrf
        @foreach ($form->inputs as $input)
        <fieldset class="form-group col-12">
            @if(isset($input['label'])) 
            <label for="">{{$input['label']}}</label>
            @endif 
            @if($input['type']=='select')
                <select name="{{$input['name']}}" class="{{$input['class']}}">
                    @foreach ($input['options'] as $option)
                        <option value="{{$option['value']}}" {{ $option['selected'] ? ' selected' : '' }}>
                            {{$option['value']}}
                        </option>
                    @endforeach
                </select>
              

            @elseif($input['type']=='checkbox' || $input['type']=='radio')
                    @foreach ($input['options'] as $option)
                        <div class="form-check">
                            <input 
                                    class="form-check-input"
                                    name="{{$input['name']}}"
                                    type="{{$input['type']}}"
                                    id="{{$option['id']}}" 

                                    @if(isset($option['value'])) value="{{$option['value']}}" @endif
                                    @if(isset($option['checked'])) checked @endif
                            >
                            <label class="form-check-label" for="{{$option['id']}}">
                                {{$option['label']}}
                            </label>
                        </div>
                    @endforeach
            @else
                <input 
                    type="{{$input['type']}}"
                    class="{{$input['class']}}"
                    @if(isset($input['value']))
                        value="{{$input['value']}}" 
                    @elseif(isset($input['name']) && old($input['name']))
                        value="{{old($input['name'])}}" 
                    @endif
                    @if(isset($input['name']))         name="{{$input['name']}}"                @endif
                    @if(isset($input['required']))     required="{{$input['required']}}"        @endif
                    @if(isset($input['placeholder']))  placeholder="{{$input['placeholder']}}"  @endif
                    @if(isset($input['min']))          min="{{$input['min']}}"                  @endif
                    @if(isset($input['max']))          max="{{$input['max']}}"                  @endif
                    @if(isset($input['maxlength']))          maxlength="{{$input['maxlength']}}"                  @endif
                >
                @if(isset($input['name']))         
                @error($input['name'])
                <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror   
                @endif
   
            @endif
        </fieldset>
        @endforeach
</form>

