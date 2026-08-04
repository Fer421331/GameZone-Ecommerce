<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">

            <h1 class="text-success text-center">
                ¡Compra realizada correctamente!
            </h1>

            <hr>

            <p class="text-center fs-5">
                Gracias por tu compra. Tu pago fue procesado correctamente.
            </p>

            <p class="text-center">
                Número de venta:
                <strong>{{venta_id}}</strong>
            </p>

            <hr>

            <h4>Productos comprados</h4>

            <table class="table table-striped">

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
                        <td>{{producto_nombre}}</td>
                        <td>{{cantidad}}</td>
                        <td>${{producto_precio}}</td>
                        <td>${{subtotal}}</td>
                    </tr>

                    {{endfor productos}}

                </tbody>

            </table>

            <hr>

            <div class="text-center">

                <a href="index.php?page=Carrito_Carrito" class="btn btn-primary">
                    Regresar al carrito
                </a>

                <a href="index.php?page=Catalogo_Catalogo" class="btn btn-secondary">
                    Seguir comprando
                </a>

            </div>

        </div>
    </div>
</div>