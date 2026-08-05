{{if errorDireccion}}

<div class="alert alert-warning">

  {{errorDireccion}}

</div>

<a href="index.php?page=DireccionesUsuario_DireccionesUsuarios" class="btn btn-primary">

  Agregar dirección de entrega

</a>

<hr>

{{endif errorDireccion}}


<a href="index.php?page=DireccionesUsuario_DireccionesUsuarios" class="btn btn-outline-primary mb-3">

  Cambiar dirección de entrega

</a>

<hr>

<h1>Confirmar compra</h1>

<hr>

<h3>Productos:</h3>

<table class="table">

  <thead>
    <tr>
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Precio</th>
      <th>Subtotal</th>
    </tr>
  </thead>

  <tbody>

    {{foreach productos}}

    <tr>
      <td>
        {{producto_nombre}}
      </td>

      <td>
        {{cantidad}}
      </td>

      <td>
        ${{producto_precio}}
      </td>

      <td>
        ${{subtotal}}
      </td>
    </tr>

    {{endfor productos}}

  </tbody>

</table>
<br>
<h3>
  Total:
  ${{total}}
</h3>
<br>
{{if direccion}}

<h3>Dirección de entrega:</h3>

<p>
  {{direccion.direccion_receptor}}
  <br>
  {{direccion.direccion_departamento}},
  {{direccion.direccion_ciudad}}
  <br>
  {{direccion.direccion_detalle}}
</p>

{{endif direccion}}
<br>
{{if puedeComprar}}

<form action="index.php?page=Checkout_Checkout" method="post">

  <button type="submit" class="btn btn-success">

    Continuar con PayPal

  </button>

</form>

{{endif puedeComprar}}


<hr>


<a href="index.php?page=Carrito_Carrito" class="btn btn-secondary">

  Regresar al carrito

</a>