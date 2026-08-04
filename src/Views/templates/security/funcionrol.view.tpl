<section class="container mt-4">

    {{with rol}}

    <h2>Administración de Funciones del Rol</h2>

    <h4>{{rolesdsc}}</h4>

    <p>Código: {{rolescod}}</p>

    {{endwith rol}}

    <hr>

    <div class="row funciones-roles-container">

        <div class="col-md-6 funciones-columna">

            <h3>Funciones Asignadas</h3>

            <label for="buscarAsignadas">
                Buscar
            </label>

            <input type="text" id="buscarAsignadas" class="form-control mb-2" placeholder="Buscar función..."
                autocomplete="off">

            <table id="tablaAsignadas" class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>Función</th>

                        <th>Acción</th>

                    </tr>

                </thead>

                <tbody>

                    {{foreach funcionesAsignadas}}

                    <tr>

                        <td>{{fndsc}}</td>

                        <td>

                            <form method="post" action="index.php?page=Security_FuncionRol&rolescod={{~rolescod}}">

                                <input type="hidden" name="fncod" value="{{fncod}}">

                                <button type="submit" name="btnEliminar" class="btn btn-danger btn-sm">

                                    Quitar

                                </button>

                            </form>

                        </td>

                    </tr>

                    {{endfor funcionesAsignadas}}

                </tbody>

            </table>

        </div>

        <div class="col-md-6 funciones-columna">

            <h3>Funciones Disponibles</h3>

            <label for="buscarDisponibles">
                Buscar
            </label>

            <input type="text" id="buscarDisponibles" class="form-control mb-2" placeholder="Buscar función..."
                autocomplete="off">

            <table id="tablaDisponibles" class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>Función</th>

                        <th>Acción</th>

                    </tr>

                </thead>

                <tbody>

                    {{foreach funcionesDisponibles}}

                    <tr>

                        <td>{{fndsc}}</td>

                        <td>

                            <form method="post" action="index.php?page=Security_FuncionRol&rolescod={{~rolescod}}">

                                <input type="hidden" name="fncod" value="{{fncod}}">

                                <button type="submit" name="btnAgregar" class="btn btn-success btn-sm">

                                    Asignar

                                </button>

                            </form>

                        </td>

                    </tr>

                    {{endfor funcionesDisponibles}}

                </tbody>

            </table>

        </div>

    </div>

    <hr>

    <a class="btn btn-secondary" href="index.php?page=Security_FuncionesRoles">

        Regresar

    </a>

</section>

<script>

    document.addEventListener("DOMContentLoaded", function () {


        function activarBuscador(inputId, tablaId) {

            const buscador =
                document.getElementById(inputId);


            const filas =
                document.querySelectorAll(
                    "#" + tablaId + " tbody tr"
                );


            if (!buscador) {
                return;
            }


            buscador.addEventListener(
                "input",
                function () {

                    const texto =
                        this.value.toLowerCase().trim();


                    filas.forEach(function (fila) {

                        const contenido =
                            fila.textContent.toLowerCase();


                        fila.style.display =
                            contenido.includes(texto)
                                ? ""
                                : "none";

                    });

                }
            );

        }


        activarBuscador(
            "buscarAsignadas",
            "tablaAsignadas"
        );


        activarBuscador(
            "buscarDisponibles",
            "tablaDisponibles"
        );


    });

</script>

<style>
    .funciones-roles-container {
        display: flex;
        justify-content: space-between;
        gap: 40px;
    }


    .funciones-columna {
        flex: 1;
    }


    .funciones-columna table {
        width: 100%;
    }


    @media (max-width: 768px) {

        .funciones-roles-container {
            flex-direction: column;
        }

    }
</style>