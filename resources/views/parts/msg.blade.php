@if(session('message'))
<div class="message"> {{session('message')}} </div>
@endif
 @if ($errors->any())
 <div class="alert message">
     <ul class="list-group">
         @foreach ($errors->all() as $error)
         <li class="list-group-item list-group-item-danger">{{$error}}</li>
         @endforeach
     </ul>
 </div>
 @endif
 <div class="message--javascript"> </div>
