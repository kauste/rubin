<a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{route('my-order')}}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
    Cart
</a>
<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
    <div class="dropdown-item">
        <a class="cart-open" href="{{route('my-order')}}">OPEN CART</a>
    </div>
    @forelse ($cart as $good)
    <div class="dropdown-item">
        <b>{{$procedures[$good['procedureId']]}}</b>
        <div>{{$good['appointmentDate']}} </div>
        <div> {{$mastersNames[$good['masterId']]}} {{$mastersSurnames[$good['masterId']]}}</div>
    </div>
    @empty
    <div class="dropdown-item">Go book an appointment
        <div />
        @endforelse
    </div>
