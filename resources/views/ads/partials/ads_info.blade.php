<!-- <li>2002</li>
<li>72,000 km</li>
<li>Petrol</li>
<li>1500 cc</li>
<li>Manual</li> -->


@if(!empty($post->show_custom_data))
<?php $fields = json_decode($post->show_custom_data , true); ?>
@foreach($fields as $key=>$field) 
<li>{{$field}}</li>

@endforeach


@endif