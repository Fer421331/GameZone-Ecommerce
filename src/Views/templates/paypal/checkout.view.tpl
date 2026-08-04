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

<form action="index.php?page=checkout_checkout" method="post">

  <button type="submit" class="btn btn-success">

    Continuar con PayPal

  </button>

</form>


<hr>


<a href="index.php?page=Carrito_Carrito" class="btn btn-secondary">

  Regresar al carrito

</a>