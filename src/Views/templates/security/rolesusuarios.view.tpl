<h1>Usuarios del Sistema</h1>

<section class="grid">

    <div class="row">

        <div class="col-8 row">

            <label class="col-3">
                Buscar
            </label>

            <input class="col-9" type="text" id="buscarUsuario" placeholder="Buscar..." autocomplete="off">

        </div>

    </div>

</section>

<br>

<table class="table" id="tablaUsuarios">
    <thead>
        <tr>
            <th>ID</th>
            <th>Correo</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Tipo</th>
            <th>Acción</th>
        </tr>
    </thead>

    <tbody>
        {{foreach usuarios}}
        <tr>
            <td>{{usercod}}</td>
            <td>{{useremail}}</td>
            <td>{{username}}</td>
            <td>{{userest}}</td>
            <td>{{usertipo}}</td>

            <td>
                <a href="index.php?page=Security_RolUsuario&usercod={{usercod}}" class="btn btn.secondary">
                    Administrar Roles
                </a>
            </td>
        </tr>
        {{endfor usuarios}}
    </tbody>

</table>
{{pagination}}
<hr>
<a href="index.php?page=Menu_Menu" class="btn btn-secondary">
    Regresar
</a>
</hr>
<script>

    document.addEventListener("DOMContentLoaded", function () {


        const buscador =
            document.getElementById(
                "buscarUsuario"
            );


        const filas =
            document.querySelectorAll(
                "#tablaUsuarios tbody tr"
            );



        if (!buscador) {
            return;
        }



        buscador.addEventListener(
            "input",
            function () {


                const texto =
                    this.value
                        .toLowerCase()
                        .trim();



                filas.forEach(function (fila) {


                    const contenido =
                        fila.textContent
                            .toLowerCase();



                    fila.style.display =
                        contenido.includes(texto)
                            ? ""
                            : "none";


                });


            }
        );


    });

</script>