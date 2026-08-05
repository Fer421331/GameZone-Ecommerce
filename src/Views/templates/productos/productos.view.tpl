<section class="productos-admin">

    <div class="productos-header">
        <div>
            <span class="productos-subtitle">GAMEZONE ADMIN PANEL</span>
            <h1>Administración de Productos</h1>
            <p>
                Gestiona el catálogo, inventario, precios y disponibilidad
                de los videojuegos.
            </p>
        </div>

        <br>

        <a href="index.php?page=Productos_Producto&mode=INS" class="btn btn-secundary">
            <span class="producto-btn-icon">+</span>
            Nuevo Producto
        </a>
    </div>

    <div class="productos-panel">

        <div class="productos-panel-header">

            <div>
                <h2>Catálogo de videojuegos</h2>
                <span>Productos registrados en el sistema</span>
            </div>

            <div class="productos-search">
                <span>⌕</span>

                <input type="text" id="buscarProducto" placeholder="Buscar producto..." autocomplete="off">
            </div>

        </div>

        <div class="table-responsive">

            <table class="productos-table" id="tablaProductos">

                <thead>
                    <tr>

                        <th>ID</th>

                        <th>Imagen</th>

                        <th>SKU</th>

                        <th>Producto</th>

                        <th>Categoría</th>

                        <th>Marca</th>

                        <th>Plataforma</th>

                        <th>Costo</th>

                        <th>Precio</th>

                        <th>Stock</th>

                        <th>Web</th>

                        <th>Estado</th>

                        <th>Acciones</th>

                    </tr>
                </thead>

                <tbody>

                    {{foreach productos}}

                    <tr>

                        <td>

                            <span class="producto-id">

                                #{{producto_id}}

                            </span>

                        </td>

                        <td>

                            {{if imagen_ruta}}

                            <img src="{{imagen_ruta}}" alt="{{producto_nombre}}" class="producto-avatar">

                            {{endif imagen_ruta}}


                            {{ifnot imagen_ruta}}

                            <span class="producto-avatar no-image">
                                🎮
                            </span>

                            {{endifnot imagen_ruta}}

                        </td>

                        <td>

                            <span class="producto-sku">

                                {{producto_sku}}

                            </span>

                        </td>

                        <td>

                            <div class="producto-nombre">

                                <div>

                                    <strong>

                                        {{producto_nombre}}

                                    </strong>

                                    <small>

                                        Videojuego

                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>

                            {{categoria_nombre}}

                        </td>

                        <td>

                            {{marca_nombre}}

                        </td>

                        <td>

                            <span class="producto-plataforma">

                                {{plataforma_nombre}}

                            </span>

                        </td>

                        <td>

                            <span class="producto-costo">

                                $ {{producto_costo}}

                            </span>

                        </td>

                        <td>

                            <strong class="producto-precio">

                                $ {{producto_precio}}

                            </strong>

                        </td>

                        <td>

                            <span class="producto-stock">

                                {{producto_stock}} unidades

                            </span>

                        </td>

                        <td>

                            <span class="producto-estado producto-estado-web">

                                {{producto_web_texto}}

                            </span>

                        </td>

                        <td>

                            <span class="producto-estado">

                                {{producto_estado_texto}}

                            </span>

                        </td>

                        <td>

                            <div class="producto-acciones">

                                <a href="index.php?page=Productos_Producto&mode=DSP&producto_id={{producto_id}}"
                                    class="producto-btn-accion producto-btn-ver btn btn-secondary">

                                    Ver

                                </a>

                                <a href="index.php?page=Productos_Producto&mode=UPD&producto_id={{producto_id}}"
                                    class="producto-btn-accion producto-btn-editar btn btn-secondary">

                                    Editar

                                </a>

                                <a href="index.php?page=Productos_Producto&mode=DEL&producto_id={{producto_id}}"
                                    class="producto-btn-accion producto-btn-desactivar btn btn-secondary">

                                    Desactivar

                                </a>

                            </div>

                        </td>

                    </tr>

                    {{endfor productos}}

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

    document.addEventListener("DOMContentLoaded", function () {

        const buscador =
            document.getElementById("buscarProducto");

        const filas =
            document.querySelectorAll(
                "#tablaProductos tbody tr"
            );

        buscador.addEventListener("input", function () {

            const texto =
                this.value
                    .toLowerCase()
                    .trim();

            filas.forEach(function (fila) {

                const nombre =
                    fila.querySelector(".producto-nombre")
                        .textContent
                        .toLowerCase();

                fila.style.display =
                    nombre.includes(texto)
                        ? ""
                        : "none";

            });

        });

    });

</script>