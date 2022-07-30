@component('mail::message')

Hola {{ $inputs['name'] }},<br/>

Se solicitó el cambio de contraseña para el correo: {{ $inputs['email']}}<br/>
Tu nueva contraseña es: {{ $inputs['password']}}<br/>

Agradecemos tu preferencia!<br/>
vsexshopgdlalcala.com.mx
@endcomponent