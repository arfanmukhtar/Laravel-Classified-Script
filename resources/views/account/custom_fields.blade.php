@if(!empty($custom_fields))
 @foreach($custom_fields as $field)
    @php $required = ""; 
    $postData = json_decode($post->custom_data , true);
    @endphp
    @if($field->type == "text")
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>

        <div class="col-sm-8">
            <input id="seller_name" name="custom[{{$field->id}}]" @if(!empty($postData[$field->id])) value="{{$postData[$field->id]}}" @endif class="form-control input-md" {{$required}}  type="text">
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
                <option value="{{$option}}" @if(!empty($postData[$field->id]) and $postData[$field->id] == $option) selected @endif>{{$option}}</option>
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
                <?php 
                     $checked = "";
                     if(is_array($postData[$field->id])) { 
                         $selectedData = $postData[$field->id];
                         if(in_array($option , $selectedData))  $checked = "checked";
                     } else { 
                         if(!empty($postData[$field->id]) and $postData[$field->id] == $option) { 
                             $checked = "checked";
                         }
                     }
                ?>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" {{$checked}}  name="custom[{{$field->id}}][]"   value="{{$option}}"> {{$option}}
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
                        <input class="form-check-input" type="radio" @if(!empty($postData[$field->id]) and $postData[$field->id] == $option) checked @endif  name="custom[{{$field->id}}]"   value="{{$option}}"> {{$option}}
                    </label>
                </div>
            @endforeach
           
        </div>
    </div>
    @endif
    @if($field->type == "textarea")
    @php 
        if(!empty($postData[$field->id])) $textData = $postData[$field->id];
    @endphp
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
        <div class="col-sm-8">
            <textarea  name="custom[{{$field->id}}]"   class="form-control input-md" rows="3" {{$required}}  type="text">{{$textData}}</textarea>
        </div>
    </div>
    @endif
    @if($field->type == "number")
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
        <div class="col-sm-8">
            <input  name="custom[{{$field->id}}]" @if(!empty($postData[$field->id])) value="{{$postData[$field->id]}}" @endif  class="form-control input-md" {{$required}}  type="number">
        </div>
    </div>
    @endif
    @if($field->type == "date" )
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
        <div class="col-sm-8">
            <input  name="custom[{{$field->id}}]"  @if(!empty($postData[$field->id])) value="{{$postData[$field->id]}}" @endif   class="form-control input-md" {{$required}}  type="text">
        </div>
    </div>
    @endif
    @if($field->type == "datetime")
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
        <div class="col-sm-8">
            <input name="custom[{{$field->id}}]"  @if(!empty($postData[$field->id])) value="{{$postData[$field->id]}}" @endif   class="form-control input-md" {{$required}}  type="text">
        </div>
    </div>
    @endif
    @if($field->type == "video" || $field->type == "url")
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="{{$field->name}}">{{$field->name}}</label>
        <div class="col-sm-8">
            <input  name="custom[{{$field->id}}]"  @if(!empty($postData[$field->id])) value="{{$postData[$field->id]}}" @endif   class="form-control input-md" {{$required}}  type="text">
        </div>
    </div>
    @endif

    

    @endforeach

@endif