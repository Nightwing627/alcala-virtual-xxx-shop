@component('mail::message')

Tienes un nuevo mensaje del formulario de contacto<br>

Nombre: {{ $contact->name }} <br/>
Email: {{ $contact->email }} <br/>
Telefono: {{ $contact->phone }} <br/>
Mensaje: {{ $contact->message }}<br/>

también puedes consultar esta información en vsexshopgdlalcala.com.mx <br>

@endcomponent