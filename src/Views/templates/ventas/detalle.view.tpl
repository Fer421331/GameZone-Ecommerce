<h1>Detalle Venta #{{venta_id}}</h1>


<section class="WWList">


    <h2>Información de la venta</h2>


    <p>
        <strong>Usuario:</strong>
        {{usercod}}
    </p>


    <p>
        <strong>Fecha:</strong>
        {{venta_fecha}}
    </p>


    <p>
        <strong>Método de pago:</strong>
        {{metodo_nombre}}
    </p>


    <p>
        <strong>Estado:</strong>
        {{venta_estado}}
    </p>


    <p>
        <strong>Total:</strong>
        ${{venta_total}}
    </p>



    <hr>



    <h2>Dirección de entrega</h2>


    <p>
        <strong>Receptor:</strong>
        {{direccion_receptor}}
    </p>


    <p>
        <strong>Teléfono:</strong>
        {{direccion_telefono}}
    </p>


    <p>
        <strong>Ubicación:</strong>
        {{direccion_departamento}},
        {{direccion_ciudad}}
    </p>


    <p>
        <strong>Detalle:</strong>
        {{direccion_detalle}}
    </p>


    <p>
        <strong>Referencia:</strong>
        {{direccion_referencia}}
    </p>



    <hr>



    <h2>Productos</h2>



    <table>


        <thead>

            <tr>

                <th>
                    Producto
                </th>

                <th>
                    Precio
                </th>

                <th>
                    Cantidad
                </th>

                <th>
                    Subtotal
                </th>

            </tr>


        </thead>



        <tbody>


            {{foreach detalle}}


            <tr>


                <td>
                    {{producto_nombre}}
                </td>


                <td>
                    ${{precio_unitario}}
                </td>


                <td>
                    {{cantidad}}
                </td>


                <td>
                    ${{subtotal}}
                </td>


            </tr>


            {{endfor detalle}}



        </tbody>


    </table>



    <br>



    <a href="index.php?page=Ventas_Ventas" class="btn btn-secondary">

        Regresar

    </a>


</section>