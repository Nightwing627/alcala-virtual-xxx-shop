<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie-edge">
    </head>
    <body>
        <table id="titulo" class="cabecera">
            <tbody>
                <tr>
                    <td align="center" valign="top" style="width: 50%">
                        <img id="logotipo" src="https://vsexshopgdlalcala.com.mx/public/images/shared/logo.png" width="200px">
                    </td>
                    <td style="width: 50%; text-align:center;" >
                        Pedido ID: {{ $order->id }}<br>
                        Fecha de pedido: {{ $order->created_at }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                      Hola {{ $user->name ? $user->name : 'usuario' }}.
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        Tu pedido se realizo con éxito.
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <table id="productos" class="cuerpo">
            <thead class="thead-gris">
                <tr>
                    <th colspan="5">Los productos de tu pedido fueron:</th>
                </tr>
                
            </thead>
            <thead class="thead-gris-bajito">
                <tr>
                    <th align="center">Sku</th>
                    <th align="center">Nombre</th>
                    <th align="center">Cantidad</th>
                    <th align="center">Precio Unitario</th>
                    <th align="center">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $detail)
                <tr>
                    <td align="center">
                        {{ $detail->product->sku }}
                    </td>
                    <td align="center">
                        {{ $detail->product->name }}
                    </td>
                    <td align="center">
                        {{ $detail->quantity }}
                    </td>
                    <td align="center">
                        {{ "$ ".number_format($detail->price, 2)." MXN" }}
                    </td>
                    <td align="center">
                        {{ "$ ".number_format($detail->price * $detail->quantity, 2)." MXN" }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
              @if($order->shippingCost)
                <tr>
                    <td class="sin-borde" colspan="3">&nbsp;</td>
                    <td align="center">Costo de Envío:</td>
                    <td align="center">{{ "$ ".number_format($order->shippingCost, 2)." MXN" }}</td>
                </tr>
              @endif
                <tr>
                  <td class="sin-borde" colspan="3">&nbsp;</td>
                  <td align="center">Total:</td>
                  <td align="center">{{ "$ ".number_format($order->total, 2)." MXN" }}</td>
                </tr>
            </tfoot>
        </table>
        <br/>
        <table class="cabecera">
          <thead>
            <tr>
              <th>Tu pedido será entregado a la siguiente dirección.</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td align="center">
              <table align="center">
                <thead></thead>
                <tbody>
                  <tr>
                    <td style="border-style:none; text-align: center;">
                        {{ $order->street }} {{ '#'.$order->num_ext }} {{ $order->num_int ? 'Número interior: '.$order->num_int : '' }}, {{ $order->neighborhood }}, {{ $order->postalCode }}. <br>
                        {{ $order->town->name }}, {{ $order->state->name }}. {{ $user->phone ? 'Teléfono: '.$user->phone : '' }}
                    </td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>
          </tbody>
        </table>

        <p>
            <strong>Si tienes cualquier duda o comentario comunícate</strong><br/><br/>
            Correo: ventas@vsexshopgdlalcala.com.mx<br/>
            Whatsapp: 3312428001<br/>
        </p>
        
    </body>
</html>
<br>


<style type="text/css">
  
body{
  font-family: sans-serif;
}
table.cuerpo {
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}
table.cuerpo td, table.cuerpo th {
  border: 1px solid #000000;
  padding: 5px 4px;
}
table.cuerpo tbody td, table.cuerpo tfoot  {
  font-size: 12px;
  font-weight: bold;
  color: #000000;
}
table.cuerpo .thead-gris{
  background: #CFCFCF;
  background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
  background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
  background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
}
table.cuerpo .thead-gris-bajito {
  background: #F0F0F0;
  background: -moz-linear-gradient(top, #f4f4f4 0%, #f1f1f1 66%, #F0F0F0 100%);
  background: -webkit-linear-gradient(top, #f4f4f4 0%, #f1f1f1 66%, #F0F0F0 100%);
  background: linear-gradient(to bottom, #f4f4f4 0%, #f1f1f1 66%, #F0F0F0 100%);
}

table.cuerpo thead th {
  font-size: 12px;
  font-weight: bold;
  color: #000000;
  text-align: center;
}
table.cuerpo tfoot td {
  font-size: 12px;
}
table.cuerpo .sin-borde{
  border-style:none;
}

table.cabecera {
  border: 3px solid #F0F0F0;
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}
table.cabecera td, table.cabecera th {
  border: 1px solid #F0F0F0;
  padding: 5px 4px;
}
table.cabecera tbody td {
  font-size: 13px;
  color: #000000;
}
table.cabecera tfoot td {
  font-size: 14px;
}
.relleno{
  background: #F0F0F0;
  font-size: 14px;
}

@media screen and (max-width: 575px) 
{
  #productos thead tr th, #productos tbody tr td, #productos tfoot tr td
  { 
    font-size: 6px !important;
  }
  #imagen {
    width: 20px;
    height: 20px;
  }
  .cabecera thead tr th, .cabecera tbody tr td{
    font-size: 8px !important;
  }
  #logotipo{
    max-height:40px;
  }
}
</style>