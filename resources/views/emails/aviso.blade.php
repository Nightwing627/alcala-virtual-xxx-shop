@component('mail::message')

#Tienes un nuevo pedido<br>

El cliente {{ $user->name }}, ha realizado el pedido con el id#{{ $order->id }}.<br>

Por favor ingrese a vsexshop.com.mx para ver su nuevo pedido <br>

@endcomponent