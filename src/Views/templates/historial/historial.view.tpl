<section class="container-l">

    <h1>Historial de Compras</h1>

    <hr>

    {{ifnot ventas}}

    <div class="alert alert-info">
        No existen compras registradas.
    </div>

    {{endifnot ventas}}

    {{foreach ventas}}

    <div class="card mb-4">

        <div class="card-header">

            <strong>Compra #{{venta_id}}</strong>

            <br>

            Fecha: {{venta_fecha}}

            <br>

            Estado: {{venta_estado}}

            <br>

            <strong>Total: L {{venta_total}}</strong>

        </div>

        <div class="card-body">

            <table class="table">

                <thead>

                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>

                </thead>

                <tbody>

                    {{foreach detalle}}

                    <tr>

                        <td>{{producto_nombre}}</td>

                        <td>L {{precio_unitario}}</td>

                        <td>{{cantidad}}</td>

                        <td>L {{subtotal}}</td>

                    </tr>

                    {{endfor detalle}}

                </tbody>

            </table>

        </div>

    </div>

    {{endfor ventas}}

    <hr>
        <a href="index.php?page=Index" class="btn btn-secondary">
            Regresar
        </a>
    </hr>
    
</section>