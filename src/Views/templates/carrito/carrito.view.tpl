<section class="container-l">

    <div class="row">

        <div class="col-12">

            <h1>Mi Carrito</h1>

            <hr>

        </div>

    </div>

    {{ifnot productos}}

    <div class="row">

        <div class="col-12">

            <div class="alert alert-info">

                Tu carrito está vacío.

            </div>

            <a href="index.php?page=Catalogo_Catalogo" class="btn btn-primary">

                Continuar comprando

            </a>

        </div>

    </div>

    {{endifnot productos}}


    {{if productos}}

    <form method="post" action="index.php?page=Carrito_Carrito&action=UPDATE">

        <table class="table">

            <thead>

                <tr>

                    <th width="120">
                        Imagen
                    </th>

                    <th>
                        Producto
                    </th>

                    <th>
                        Precio
                    </th>

                    <th width="120">
                        Cantidad
                    </th>

                    <th>
                        Subtotal
                    </th>

                    <th width="100">
                    </th>

                </tr>

            </thead>

            <tbody>

                {{foreach productos}}

                <tr>

                    <td>

                        <img src="{{imagen_ruta}}" alt="{{producto_nombre}}" style="width:100px;">

                    </td>

                    <td>

                        <strong>

                            {{producto_nombre}}

                        </strong>

                        <br>

                        {{categoria_nombre}}

                        <br>

                        {{marca_nombre}}

                        <br>

                        {{plataforma_nombre}}

                    </td>

                    <td>

                        L {{producto_precio}}

                    </td>

                    <td>

                        <input type="number" min="1" name="cantidad[{{producto_id}}]" value="{{cantidad}}"
                            class="form-control">

                    </td>

                    <td>

                        L {{subtotal}}

                    </td>

                    <td>

                        <a href="index.php?page=Carrito_Carrito&action=REMOVE&producto_id={{producto_id}}"
                            class="btn btn-danger">

                            Eliminar

                        </a>

                    </td>

                </tr>

                {{endfor productos}}

            </tbody>

        </table>

        <div class="row">

            <div class="col-6">

                <a href="index.php?page=Catalogo_Catalogo" class="btn btn-secondary">

                    Seguir Comprando

                </a>

                <a href="index.php?page=Carrito_Carrito&action=CLEAR" class="btn btn-warning">

                    Vaciar Carrito

                </a>

            </div>

            <div class="col-6" style="text-align:right;">

                <h2>

                    Total: L {{total}}

                </h2>

                <button type="submit" class="btn btn-primary">

                    Actualizar Carrito

                </button>

                <a href="index.php?page=Checkout_Checkout" class="btn btn-success">

                    Proceder al Pago

                </a>

            </div>

        </div>

    </form>

    {{endif productos}}

    <hr>
        <a href="index.php?page=Catalogo_Catalogo" class="btn btn-secondary">
            Regresar
        </a>
    </hr>

</section>