<h1>Ventas</h1>


<section class="grid">

    <div class="row">

        <form class="col-12 col-m-8" action="index.php" method="get">


            <div class="flex align-center">


                <div class="col-8 row">


                    <label class="col-3" for="buscarVenta">
                        Buscar
                    </label>


                    <input class="col-9" type="text" id="buscarVenta" name="buscar" value="{{buscar}}"
                        placeholder="Buscar venta..." autocomplete="off">



                    <label class="col-3" for="estado">
                        Estado
                    </label>


                    <select class="col-9" name="estado" id="estado">


                        <option value="">
                            Todos
                        </option>


                        <option value="APR">
                            Aprobada
                        </option>


                        <option value="PEN">
                            Pendiente
                        </option>


                        <option value="CAN">
                            Cancelada
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



    <table id="tablaVentas">


        <thead>


            <tr>

                <th>
                    ID
                </th>

                <th>
                    Usuario
                </th>

                <th>
                    Fecha
                </th>

                <th>
                    Método Pago
                </th>

                <th>
                    Total
                </th>

                <th>
                    Estado
                </th>

                <th>
                    Acciones
                </th>


            </tr>


        </thead>



        <tbody>



            {{foreach ventas}}



            <tr>



                <td>

                    {{venta_id}}

                </td>



                <td>

                    {{usercod}}

                </td>



                <td>

                    {{venta_fecha}}

                </td>



                <td>

                    {{metodo_nombre}}

                </td>



                <td>

                    ${{venta_total}}

                </td>



                <td>

                    {{venta_estado}}

                </td>



                <td>



                    <a href="index.php?page=Ventas_Detalle&venta_id={{venta_id}}" class="btn btn-info">

                        Ver

                    </a>



                </td>



            </tr>



            {{endfor ventas}}



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

    document.addEventListener(
        "DOMContentLoaded",
        function () {


            const buscador =
                document.getElementById(
                    "buscarVenta"
                );



            const filas =
                document.querySelectorAll(
                    "#tablaVentas tbody tr"
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



                    filas.forEach(
                        function (fila) {


                            const contenido =
                                fila.textContent
                                    .toLowerCase();



                            fila.style.display =
                                contenido.includes(texto)
                                    ?
                                    ""
                                    :
                                    "none";


                        }
                    );


                }
            );


        }
    );

</script>