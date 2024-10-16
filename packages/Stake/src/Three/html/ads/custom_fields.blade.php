 @if(!empty($custom_fields))
 <div class="content-subheading"><i class="icon-user fa"></i> <strong>{{ trans('custom_fields.aditional_information') }}</strong></div>
 @foreach($custom_fields as $field)
    @php $required = ""; @endphp
    @if($field->type == "text")
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>

        <div class="col-sm-8">
            <input id="seller_name" name="custom[{{$field->id}}]"  class="form-control input-md" {{$required}}  type="text">
        </div>
    </div>
    @endif
    @if($field->type == "dropbox")
    <div class="form-group row">
    <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
        <?php 
            $options = json_decode($field->options , true);
        ?>
        <div class="col-sm-8">
            <select class="form-control input-md" name="custom[{{$field->id}}]"  >
                @foreach($options as $option)
                <option value="{{$option}}">{{$option}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif
    @if($field->type == "checkbox")
    <div class="form-group row">
        <label for="{{$field->name}}" class="col-sm-3 col-form-label" >{{$field->name}}</label>
        <?php 
            $options = json_decode($field->options , true);
        ?>
        <div class="col-sm-8">
            @foreach($options as $option)
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox"  name="custom[{{$field->id}}][]"   value="{{$option}}"> {{$option}}
                    </label>
                </div>
            @endforeach
           
        </div>
    </div>
    @endif

    @if($field->type == "radio")
    <div class="form-group row">
        <label for="{{$field->name}}" class="col-sm-3 col-form-label" >{{$field->name}}</label>
        <?php 
            $options = json_decode($field->options , true);
        ?>
        <div class="col-sm-8">
            @foreach($options as $option)
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio"  name="custom[{{$field->id}}]"   value="{{$option}}"> {{$option}}
                    </label>
                </div>
            @endforeach
           
        </div>
    </div>
    @endif
    @if($field->type == "textarea")
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
        <div class="col-sm-8">
            <textarea  name="custom[{{$field->id}}]"   class="form-control input-md" rows="3" {{$required}}  type="text"></textarea>
        </div>
    </div>
    @endif
    @if($field->type == "number")
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
        <div class="col-sm-8">
            <input  name="custom[{{$field->id}}]"  class="form-control input-md" {{$required}}  type="number">
        </div>
    </div>
    @endif
    @if($field->type == "date" )
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
        <div class="col-sm-8">
            <input  name="custom[{{$field->id}}]"  class="form-control input-md" {{$required}}  type="text">
        </div>
    </div>
    @endif
    @if($field->type == "datetime")
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
        <div class="col-sm-8">
            <input name="custom[{{$field->id}}]"  class="form-control input-md" {{$required}}  type="text">
        </div>
    </div>
    @endif
    @if($field->type == "video" || $field->type == "url")
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
        <div class="col-sm-8">
            <input  name="custom[{{$field->id}}]"   class="form-control input-md" {{$required}}  type="text">
        </div>
    </div>
    @endif

    

    @endforeach

@endif