<h1>Rutas de Entrega</h1>

<section class="WWList">

    <section class="grid">

        <div class="row">

            <form class="col-12 col-m-8" action="index.php" method="get">

                <input type="hidden" name="page" value="RutasEntrega_RutasEntrega">

                <div class="flex align-center">

                    <div class="col-8 row">

                        <label class="col-3">
                            Buscar
                        </label>

                        <input class="col-9" type="text" id="buscarRuta" name="partialName" value="{{partialName}}"
                            placeholder="Origen o destino">

                        <label class="col-3">
                            Estado
                        </label>

                        <select class="col-9" name="status">

                            <option value="">Todos</option>
                            <option value="ACT">Activo</option>
                            <option value="INA">Inactivo</option>

                        </select>

                    </div>

                    <div class="col-4 align-end">

                        <button type="submit">
                            Filtrar
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </section>

    <br>

    <a href="index.php?page=RutasEntrega_RutaEntrega&mode=INS" class="btn btn-primary">
        + Nueva Ruta
    </a>
    <hr>
    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Distancia (Km)</th>
                <th>Duración (Min)</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            {{foreach rutasentrega}}

            <tr>

                <td>{{id_ruta}}</td>
                <td>{{origen}}</td>
                <td>{{destino}}</td>
                <td>{{distancia_km}}</td>
                <td>{{duracion_min}}</td>
                <td>{{estado}}</td>

                <td>

                    <div class="acciones">

                        <a href="index.php?page=RutasEntrega_RutaEntrega&mode=DSP&id_ruta={{id_ruta}}"
                            class="btn btn-info">
                            Ver
                        </a>

                        <a href="index.php?page=RutasEntrega_RutaEntrega&mode=UPD&id_ruta={{id_ruta}}"
                            class="btn btn-warning">
                            Editar
                        </a>

                        <a href="index.php?page=RutasEntrega_RutaEntrega&mode=DEL&id_ruta={{id_ruta}}"
                            class="btn btn-danger">
                            Eliminar
                        </a>

                    </div>

                </td>
            </tr>

            {{endfor rutasentrega}}

        </tbody>

    </table>

    {{pagination}}

    <hr>

    <a href="index.php?page=Menu_Menu" class="btn tn-back">
        Regresar
    </a>

</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {

    const buscador = document.getElementById("buscarRuta");
    const filas = document.querySelectorAll("table tbody tr");

    buscador.addEventListener("input", function () {

        const texto = this.value.toLowerCase();

        filas.forEach(function (fila) {

            fila.style.display =
                fila.textContent.toLowerCase().includes(texto)
                ? ""
                : "none";

        });

    });

});
</script>