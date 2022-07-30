@component('mail::message')

Hola {{ $cliente['name'] }}, bienvenido!<br>

Hemos creado una cuenta con tu correo electronico.<br><br>

Correo: {{ $cliente['email'] }}<br/>
contraseña: {{ $cliente['password']}}<br/>

No contestar en este correo cualquier duda o aclaración a:<br/>
ventas@vsexshopgdlalcala.com.mx
<br/>
Agradecemos tu preferencia!<br/>
vsexshopgdlalcala.com.mx
@endcomponent