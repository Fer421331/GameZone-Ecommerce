<section class="productos-admin">

    <div class="productos-header">

        <div>
            <span class="productos-subtitle">
                GAMEZONE ADMIN PANEL
            </span>

            <h1>
                Administración de Marcas
            </h1>

            <p>
                Gestiona las marcas asociadas a los videojuegos.
            </p>

        </div>


        <br>


        <a href="index.php?page=Marcas_Marca&mode=INS" class="btn btn-secundary">

            +
            Nueva Marca

        </a>


    </div>


    <div class="productos-panel">


        <div class="productos-panel-header">


            <div>

                <h2>
                    Catálogo de marcas
                </h2>

                <span>
                    Marcas registradas en el sistema
                </span>

            </div>



            <div class="productos-search">

                <span>
                    ⌕
                </span>


                <input type="text" id="buscarMarca" placeholder="Buscar marca...">

            </div>


        </div>




        <div class="table-responsive">


            <table class="productos-table" id="tablaMarcas">


                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Marca</th>

                        <th>Descripción</th>

                        <th>Estado</th>

                        <th>Acciones</th>

                    </tr>

                </thead>



                <tbody>


                    {{foreach marcas}}


                    <tr>


                        <td>

                            #{{marca_id}}

                        </td>



                        <td>

                            <strong>
                                {{marca_nombre}}
                            </strong>

                        </td>




                        <td>

                            {{marca_descripcion}}

                        </td>




                        <td>

                            <span class="producto-estado">

                                {{marca_estado_texto}}

                            </span>

                        </td>




                        <td>


                            <div class="producto-acciones">


                                <a href="index.php?page=Marcas_Marca&mode=DSP&marca_id={{marca_id}}"
                                    class="btn btn-secondary">

                                    Ver

                                </a>



                                <a href="index.php?page=Marcas_Marca&mode=UPD&marca_id={{marca_id}}"
                                    class="btn btn-secondary">

                                    Editar

                                </a>



                            </div>


                        </td>


                    </tr>


                    {{endfor marcas}}



                </tbody>


            </table>


        </div>



        {{pagination}}



        <hr>


        <a href="index.php?page=Menu_Menu" class="btn btn-secondary">

            Regresar

        </a>


    </div>


</section>




<script>

    document.addEventListener(
        "DOMContentLoaded",
        function () {


            const buscador =
                document.getElementById(
                    "buscarMarca"
                );


            const filas =
                document.querySelectorAll(
                    "#tablaMarcas tbody tr"
                );



            if (!buscador)
                return;



            buscador.addEventListener(
                "input",
                function () {


                    let texto =
                        this.value
                            .toLowerCase()
                            .trim();



                    filas.forEach(
                        function (fila) {


                            let contenido =
                                fila.textContent
                                    .toLowerCase();



                            fila.style.display =
                                contenido.includes(texto)
                                    ?
                                    ""
                                    :
                                    "none";


                        });



                });


        });


</script>