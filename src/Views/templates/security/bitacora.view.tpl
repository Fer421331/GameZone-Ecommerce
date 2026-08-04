<h1>Bitácora</h1>


<section class="grid">

    <div class="row">

        <form class="col-12" action="index.php" method="get">

            <div class="flex align-center">

                <div class="col-8 row">

                    <input type="hidden" name="page" value="Security_Bitacora">


                    <label class="col-3">
                        Desde
                    </label>

                    <input class="col-9" type="date" name="fechaDesde" value="{{fechaDesde}}">


                    <label class="col-3">
                        Hasta
                    </label>

                    <input class="col-9" type="date" name="fechaHasta" value="{{fechaHasta}}">


                </div>


                <div class="col-4 align-end">

                    <button type="submit">
                        Filtrar
                    </button>

                    <a href="index.php?page=Security_Bitacora&clear=1" class="btn btn-secondary">
                        Limpiar
                    </a>

                </div>


            </div>

        </form>

    </div>

</section>


<br>


<section class="grid">

    <div class="row">

        <div class="col-12">

            <div class="flex align-center">

                <div class="col-8 row">

                    <label class="col-3" for="buscarBitacora">
                        Buscar
                    </label>

                    <input class="col-9" type="text" id="buscarBitacora" placeholder="Buscar..." autocomplete="off">

                </div>

            </div>

        </div>

    </div>

</section>


<br>


<section class="WWList">

    <table id="tablaBitacora">

        <thead>

            <tr>

                <th>Fecha</th>
                <th>Usuario</th>
                <th>Módulo</th>
                <th>Acción</th>
                <th>Observación</th>

            </tr>

        </thead>


        <tbody>

            {{foreach bitacora}}

            <tr>

                <td>{{bitacorafch}}</td>

                <td>{{username}}</td>

                <td>{{bitprograma}}</td>

                <td>{{bitdescripcion}}</td>

                <td>{{bitobservacion}}</td>

            </tr>

            {{endfor bitacora}}

        </tbody>


    </table>

    {{pagination}}

    <hr>

    <a href="index.php?page=Menu_Menu" class="btn btn-secondary">
        Regresar
    </a>

    </hr>


</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const buscador = document.getElementById("buscarBitacora");
        const filas = document.querySelectorAll("#tablaBitacora tbody tr");

        if (!buscador) {
            return;
        }

        buscador.addEventListener("input", function () {

            const texto = this.value.toLowerCase().trim();

            filas.forEach(function (fila) {

                const contenido = fila.textContent.toLowerCase();

                fila.style.display =
                    contenido.includes(texto)
                        ? ""
                        : "none";

            });

        });

    });
</script>