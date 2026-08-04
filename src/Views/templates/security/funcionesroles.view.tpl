<h1>Asignar Funciones a Roles</h1>

<section class="grid">

    <div class="row">

        <div class="col-12">

            <div class="flex align-center">

                <div class="col-8 row">

                    <label class="col-3" for="buscarRol">
                        Buscar
                    </label>


                    <input class="col-9" type="text" id="buscarRol" placeholder="Buscar rol..." autocomplete="off">

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
                <th>Código</th>
                <th>Rol</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>

        <tbody>

            {{foreach roles}}

            <tr>

                <td>
                    {{rolescod}}
                </td>

                <td>
                    {{rolesdsc}}
                </td>

                <td>
                    {{rolesest}}
                </td>

                <td>
                    <a href="index.php?page=Security_FuncionRol&rolescod={{rolescod}}" class="btn btn-secondary">
                        Administrar funciones
                    </a>
                </td>

            </tr>

            {{endfor roles}}

        </tbody>

    </table>

    <hr>
    <a href="index.php?page=Menu_Menu" class="btn btn-secondary">
        Regresar
    </a>
    </hr>

</section>

<script>

    document.addEventListener("DOMContentLoaded", function () {

        const buscador =
            document.getElementById("buscarRol");


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