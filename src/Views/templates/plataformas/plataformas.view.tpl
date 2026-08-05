<section class="plataformas-admin">

    <div class="productos-header">

        <div>

            <span class="productos-subtitle">
                GAMEZONE ADMIN PANEL
            </span>

            <h1>
                Administración de Plataformas
            </h1>

            <p>
                Gestiona las plataformas disponibles para los videojuegos.
            </p>

        </div>


        <br>


        <a href="index.php?page=Plataformas_Plataforma&mode=INS"
           class="btn btn-secundary">

            <span class="producto-btn-icon">
                +
            </span>

            Nueva Plataforma

        </a>


    </div>



    <div class="productos-panel">


        <div class="productos-panel-header">

            <div>

                <h2>
                    Plataformas registradas
                </h2>

                <span>
                    Consolas y sistemas disponibles
                </span>

            </div>



            <div class="productos-search">

                <span>
                    ⌕
                </span>


                <input
                    type="text"
                    id="buscarPlataforma"
                    placeholder="Buscar plataforma..."
                    autocomplete="off"
                >

            </div>


        </div>





        <div class="table-responsive">


            <table class="productos-table"
                   id="tablaPlataformas">


                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Nombre</th>

                        <th>Descripción</th>

                        <th>Estado</th>

                        <th>Acciones</th>

                    </tr>

                </thead>



                <tbody>


                    {{foreach plataformas}}


                    <tr>


                        <td>

                            <span class="producto-id">

                                #{{plataforma_id}}

                            </span>

                        </td>



                        <td>

                            <div class="producto-nombre">


                                <span class="producto-avatar">

                                    🎮

                                </span>


                                <div>

                                    <strong>
                                        {{plataforma_nombre}}
                                    </strong>


                                    <small>
                                        Plataforma gaming
                                    </small>


                                </div>


                            </div>


                        </td>





                        <td>

                            {{plataforma_descripcion}}

                        </td>





                        <td>


                            <span class="producto-estado">

                                {{estado_texto}}

                            </span>


                        </td>





                        <td>


                            <div class="producto-acciones">


                                <a href="index.php?page=Plataformas_Plataforma&mode=DSP&plataforma_id={{plataforma_id}}"
                                   class="producto-btn-accion producto-btn-ver btn btn-secondary">

                                    Ver

                                </a>




                                <a href="index.php?page=Plataformas_Plataforma&mode=UPD&plataforma_id={{plataforma_id}}"
                                   class="producto-btn-accion producto-btn-editar btn btn-secondary">

                                    Editar

                                </a>





                                <a href="index.php?page=Plataformas_Plataforma&mode=DEL&plataforma_id={{plataforma_id}}"
                                   class="producto-btn-accion producto-btn-desactivar btn btn-secondary">

                                    Desactivar

                                </a>



                            </div>


                        </td>


                    </tr>



                    {{endfor plataformas}}


                </tbody>


            </table>


        </div>




        {{pagination}}



        <hr>


        <a href="index.php?page=Menu_Menu"
           class="btn btn-secondary">

            Regresar

        </a>


        </hr>


    </div>


</section>





<script>


document.addEventListener(
    "DOMContentLoaded",
    function(){


        const buscador =
            document.getElementById(
                "buscarPlataforma"
            );


        const filas =
            document.querySelectorAll(
                "#tablaPlataformas tbody tr"
            );



        if(!buscador){

            return;

        }




        buscador.addEventListener(
            "input",
            function(){


                const texto =
                    this.value
                    .toLowerCase()
                    .trim();




                filas.forEach(
                    function(fila){


                        const nombre =
                            fila
                            .querySelector(".producto-nombre")
                            .textContent
                            .toLowerCase();



                        fila.style.display =
                            nombre.includes(texto)
                            ? ""
                            : "none";


                    }
                );



            }
        );


    }
);


</script>