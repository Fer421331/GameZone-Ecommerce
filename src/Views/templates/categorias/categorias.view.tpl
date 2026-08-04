<h1>Categorías</h1>


<section class="grid">

    <div class="row">

        <form class="col-12 col-m-8" action="index.php" method="get">

            <div class="flex align-center">

                <div class="col-8 row">


                    <input type="hidden" name="page" value="Categorias_Categorias">


                    <label class="col-3" for="partialName">
                        Buscar
                    </label>


                    <input class="col-9" type="text" id="buscarCategoria" name="partialName" value="{{partialName}}"
                        placeholder="Buscar categoría..." autocomplete="off">


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


    <a href="index.php?page=Categorias_Categoria&mode=INS" class="btn btn-secondary">

        + Nueva Categoría

    </a>


    <br>
    <br>


    <table id="tablaCategorias">


        <thead>

            <tr>

                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Fecha Creación</th>
                <th>Acciones</th>

            </tr>


        </thead>


        <tbody>


            {{foreach categorias}}


            <tr>


                <td>
                    {{categoria_id}}
                </td>


                <td>
                    {{categoria_nombre}}
                </td>


                <td>
                    {{categoria_descripcion}}
                </td>


                <td>
                    {{categoria_estado}}
                </td>


                <td>
                    {{categoria_fecha_creacion}}
                </td>


                <td>


                    <a href="index.php?page=Categorias_Categoria&mode=DSP&categoria_id={{categoria_id}}"
                        class="btn btn-info">

                        Ver

                    </a>


                    <a href="index.php?page=Categorias_Categoria&mode=UPD&categoria_id={{categoria_id}}"
                        class="btn btn-warning">

                        Editar

                    </a>


                    <a href="index.php?page=Categorias_Categoria&mode=DEL&categoria_id={{categoria_id}}"
                        class="btn btn-danger">

                        Eliminar

                    </a>


                </td>


            </tr>


            {{endfor categorias}}


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
            document.getElementById("buscarCategoria");


        const filas =
            document.querySelectorAll(
                "#tablaCategorias tbody tr"
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