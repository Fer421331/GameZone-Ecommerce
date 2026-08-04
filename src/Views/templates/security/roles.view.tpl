<h1>Roles</h1>
<br>

<section class="grid">

    <div class="row">

        <div class="col-12">

            <div class="flex align-center">

                <div class="col-8 row">

                    <label class="col-3" for="buscarRoles">
                        Buscar
                    </label>

                    <input class="col-9" type="text" id="buscarRoles" placeholder="Buscar rol..." autocomplete="off">

                </div>

            </div>

        </div>

    </div>

</section>

<br>


<section class="WWList">

    <table id="tablaRoles">

        <thead>

            <tr>

                <th>
                    Código
                </th>

                <th>
                    Descripción
                </th>

                <th>
                    Estado
                </th>

                <th>
                    <a href="index.php?page=Security_Rol&mode=INS" class="btn btn-secondary">
                        Nuevo
                    </a>
                </th>

            </tr>

        </thead>


        <tbody>

            {{foreach roles}}

            <tr>

                <td>
                    {{rolescod}}
                </td>


                <td>
                    <a href="index.php?page=Security_Rol&mode=DSP&rolescod={{rolescod}}" class="btn btn-secondary">
                        {{rolesdsc}}
                    </a>

                </td>


                <td class="center">
                    {{rolesest}}
                </td>


                <td class="center">

                    <a href="index.php?page=Security_Rol&mode=UPD&rolescod={{rolescod}}" class="btn btn-secondary">
                        Editar
                    </a>


                    <a href="index.php?page=Security_Rol&mode=DEL&rolescod={{rolescod}}" class="btn btn-secondary">
                        Eliminar
                    </a>

                </td>

            </tr>

            {{endfor roles}}

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

        const buscador =
            document.getElementById("buscarRoles");

        const filas =
            document.querySelectorAll(
                "#tablaRoles tbody tr"
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

    });

</script>