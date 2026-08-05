<section class="container-l">

    <h1>Historial de Compras</h1>

    <hr>

    {{ifnot ventas}}

    <div class="alert alert-info">
        No existen compras registradas.
    </div>

    {{endifnot ventas}}

    

    <div class="flex align-center">

        <label for="buscarHistorial">
            Buscar
        </label>

        <input type="text" id="buscarHistorial" placeholder="Buscar compra..." autocomplete="off">

    </div>

    <hr>

    {{foreach ventas}}

    <div class="card mb-4 historial-item">

        <div class="card-header">

            <strong>Compra #{{venta_id}}</strong>

            <br>

            Fecha: {{venta_fecha}}

            <br>

            Estado: {{venta_estado}}

            <br>

            <strong>Total: $ {{venta_total}}</strong>

        </div>
        <br>
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

                        <td>$ {{precio_unitario}}</td>

                        <td>{{cantidad}}</td>

                        <td>$ {{subtotal}}</td>

                    </tr>

                    {{endfor detalle}}

                </tbody>

            </table>

        </div>

    </div>
    <br>
    {{endfor ventas}}

    <hr>
    <a href="index.php?page=Index" class="btn btn-secondary">
        Regresar
    </a>
    </hr>

</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const buscador = document.getElementById("buscarHistorial");
        const compras = document.querySelectorAll(".historial-item");

        if (!buscador) {
            return;
        }

        buscador.addEventListener("input", function () {

            const texto = this.value.toLowerCase().trim();

            compras.forEach(function (compra) {

                const contenido = compra.textContent.toLowerCase();

                compra.style.display =
                    contenido.includes(texto)
                        ? ""
                        : "none";

            });

        });

    });
</script>