<section class="container">

    <h1>Mis direcciones de entrega</h1>

    <hr>


    <a href="index.php?page=DireccionesUsuario_DireccionUsuario&mode=INS" class="btn btn-primary">

        + Nueva dirección

    </a>


    <br><br>


    <div class="table-responsive">

        <table class="table table-bordered">


            <thead>

                <tr>

                    <th>Alias</th>

                    <th>Receptor</th>

                    <th>Teléfono</th>

                    <th>Ciudad</th>

                    <th>Ruta</th>

                    <th>Predeterminada</th>

                    <th>Acciones</th>

                </tr>

            </thead>



            <tbody>


                {{foreach direcciones}}


                <tr>


                    <td>

                        {{direccion_alias}}

                    </td>



                    <td>

                        {{direccion_receptor}}

                    </td>



                    <td>

                        {{direccion_telefono}}

                    </td>



                    <td>

                        {{direccion_ciudad}}

                    </td>



                    <td>

                        {{origen}}

                        →

                        {{destino}}

                    </td>



                    <td>


                        {{if direccion_predeterminada}}

                        <span class="badge bg-success">

                            Principal

                        </span>


                        {{endif direccion_predeterminada}}


                    </td>




                    <td>


                        <a href="index.php?page=DireccionesUsuario_DireccionUsuario&mode=DSP&direccion_id={{direccion_id}}"
                            class="btn btn-info">

                            Ver

                        </a>



                        <a href="index.php?page=DireccionesUsuario_DireccionUsuario&mode=UPD&direccion_id={{direccion_id}}"
                            class="btn btn-warning">

                            Editar

                        </a>


                        <a href="index.php?page=DireccionesUsuario_DireccionesUsuarios&action=principal&direccion_id={{direccion_id}}"
                            class="btn btn-success btn-sm">

                            Usar esta

                        </a>


                        <a href="index.php?page=DireccionesUsuario_DireccionUsuario&mode=DEL&direccion_id={{direccion_id}}"
                            class="btn btn-danger">

                            Eliminar

                        </a>



                    </td>


                </tr>



                {{endfor direcciones}}



            </tbody>


        </table>


    </div>


    <hr>



    <a href="index.php?page=Checkout_Checkout" class="btn btn-secondary">
        Ir al checkout
    </a>

</section>