<div style="max-width:1150px; margin:auto;">

    <h1 style="margin-bottom:30px;">
        Dashboard Administrativo
    </h1>

    <section class="WWList">

        <div style="
            display:flex;
            justify-content:space-between;
            gap:20px;
            flex-wrap:wrap;
            margin-bottom:45px;
        ">

            <div style="
                flex:1;
                min-width:180px;
                background:#6f8f55;
                color:white;
                border-radius:12px;
                padding:25px;
                text-align:center;
                box-shadow:0 4px 12px rgba(0,0,0,.15);
            ">
                <h3 style="margin:0;">Productos</h3>

                <div style="
                    font-size:42px;
                    font-weight:bold;
                    margin-top:15px;
                ">
                    {{totalProductos}}
                </div>
            </div>

            <div style="
                flex:1;
                min-width:180px;
                background:#46739f;
                color:white;
                border-radius:12px;
                padding:25px;
                text-align:center;
                box-shadow:0 4px 12px rgba(0,0,0,.15);
            ">
                <h3 style="margin:0;">Categorías</h3>

                <div style="
                    font-size:42px;
                    font-weight:bold;
                    margin-top:15px;
                ">
                    {{totalCategorias}}
                </div>
            </div>

            <div style="
                flex:1;
                min-width:180px;
                background:#cc8b2d;
                color:white;
                border-radius:12px;
                padding:25px;
                text-align:center;
                box-shadow:0 4px 12px rgba(0,0,0,.15);
            ">
                <h3 style="margin:0;">Usuarios</h3>

                <div style="
                    font-size:42px;
                    font-weight:bold;
                    margin-top:15px;
                ">
                    {{totalUsuarios}}
                </div>
            </div>

            <div style="
                flex:1;
                min-width:180px;
                background:#b54d4d;
                color:white;
                border-radius:12px;
                padding:25px;
                text-align:center;
                box-shadow:0 4px 12px rgba(0,0,0,.15);
            ">
                <h3 style="margin:0;">Ventas</h3>

                <div style="
                    font-size:42px;
                    font-weight:bold;
                    margin-top:15px;
                ">
                    {{totalVentas}}
                </div>
            </div>

        </div>

        <h2 style="margin-bottom:15px;">
            Últimos Productos Registrados
        </h2>

        <table>

            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                </tr>
            </thead>

            <tbody>

                {{foreach ultimosProductos}}

                <tr>
                    <td>{{producto_nombre}}</td>
                    <td>{{categoria_nombre}}</td>
                    <td style="text-align:right;">
                        L {{producto_precio}}
                    </td>
                    <td style="text-align:center;">
                        {{producto_stock}}
                    </td>
                </tr>

                {{endfor ultimosProductos}}

                {{ifnot ultimosProductos}}

                <tr>
                    <td colspan="4" style="text-align:center;">
                        No hay productos registrados.
                    </td>
                </tr>

                {{endifnot ultimosProductos}}

            </tbody>

        </table>

        <div style="height:40px;"></div>

        <h2 style="margin-bottom:15px;">
            Últimas Ventas Registradas
        </h2>

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>

                {{foreach ultimasVentas}}

                <tr>
                    <td style="text-align:center;">
                        {{venta_id}}
                    </td>

                    <td>{{username}}</td>

                    <td>{{venta_fecha}}</td>

                    <td style="text-align:right;">
                        L {{venta_total}}
                    </td>

                    <td style="text-align:center;">
                        {{venta_estado}}
                    </td>
                </tr>

                {{endfor ultimasVentas}}

                {{ifnot ultimasVentas}}

                <tr>
                    <td colspan="5" style="text-align:center;">
                        No hay ventas registradas.
                    </td>
                </tr>

                {{endifnot ultimasVentas}}

            </tbody>

        </table>

        <div style="height:40px;"></div>

        <h2 style="margin-bottom:15px;">
            Productos con Stock Bajo
        </h2>

        <table>

            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Stock</th>
                </tr>
            </thead>

            <tbody>

                {{foreach stockBajo}}

                <tr>
                    <td>{{producto_nombre}}</td>

                    <td style="text-align:center;">
                        {{producto_stock}}
                    </td>
                </tr>

                {{endfor stockBajo}}

                {{ifnot stockBajo}}

                <tr>
                    <td colspan="2" style="text-align:center;">
                        No hay productos con stock bajo.
                    </td>
                </tr>

                {{endifnot stockBajo}}

            </tbody>

        </table>

    </section>

</div> 

