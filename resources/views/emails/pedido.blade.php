@component('mail::message')

#Hola {{ $user->name }}! <br>

Pedido realizado con numero de pedido: {{ $order->id }} <br/>
Favor de enviarnos el comprobante de pago al siguiente correo:<br/> 
ventas@vsexshopgdlalcala.com.mx <br/>
	
Por favor conserve el recibo adjunto para cualquier aclaración.<br/>

No contestar en este correo cualquier duda o aclaración a:<br/>
ventas@vsexshopgdlalcala.com.mx
<br/>

vsexshopgdlalcala.com.mx agradece su preferencia!
@endcomponent
