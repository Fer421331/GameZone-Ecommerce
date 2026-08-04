<h1>Funciones</h1>

<section class="grid">
    <div class="row">
        <form class="col-12 col-m-8" action="index.php" method="get">

            <div class="flex align-center">

                <div class="col-8 row">

                    <input type="hidden" name="page" value="Security_Funciones">


                    <label class="col-3" for="partialName">
                        Descripción
                    </label>

                    <input class="col-9" type="text" name="partialName" id="buscarFuncion" value="{{partialName}}" />

                    <label class="col-3" for="status">
                        Estado
                    </label>

                    <select class="col-9" name="status" id="status">

                        <option value="">
                            Todos
                        </option>

                        <option value="ACT">
                            Activo
                        </option>

                        <option value="INA">
                            Inactivo
                        </option>

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
<section class="WWList">

    <table id="tablaFunciones">

        <thead>

            <tr>

                <th>
                    Código
                </th>

                <th>
                    Descripción
                </th>

                <th>
                    Tipo
                </th>

                <th>
                    Estado
                </th>

                <th>
                    <a href="index.php?page=Security_Funcion&mode=INS" class="btn btn-secondary">
                        Crear
                    </a>
                </th>

            </tr>

        </thead>



        <tbody>


            {{foreach funciones}}

            <tr>


                <td>
                    {{fncod}}
                </td>



                <td>

                    <a href="index.php?page=Security_Funcion&mode=DSP&fncod={{fncod}}" class="btn btn-secondary">
                        {{fndsc}}
                    </a>

                </td>



                <td class="center">
                    {{fntyp}}
                </td>



                <td class="center">
                    {{fnest}}
                </td>



                <td class="center">

                    <a href="index.php?page=Security_Funcion&mode=UPD&fncod={{fncod}}" class="btn btn-secondary">
                        Editar
                    </a>


                    <a href="index.php?page=Security_Funcion&mode=DEL&fncod={{fncod}}" class="btn btn-secondary">
                        Eliminar
                    </a>

                </td>


            </tr>


            {{endfor funciones}}


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

        const buscador = document.getElementById("buscarFuncion");
        const filas = document.querySelectorAll("#tablaFunciones tbody tr");

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