<section class="catalog-container">

    <div class="catalog-header">

        <h1>Catálogo de Videojuegos</h1>

        <p>
            Descubre los mejores videojuegos
            disponibles en GameZone.
        </p>

    </div>

    <br>

    <form method="GET" action="index.php" class="catalog-filters">

        <input type="hidden" name="page" value="Catalogo_Catalogo">

        <!-- Buscar -->
        <div class="filter-group">

            <label>Buscar videojuego</label>

            <input type="text" name="buscar" value="{{buscar}}" placeholder="Ej. GTA V, FIFA, Mario...">

        </div>

        <!-- Categoría -->
        <div class="filter-group">

            <label>Categoría</label>

            <select name="categoria">

                <option value="0">
                    Todas
                </option>

                {{foreach categorias}}

                <option value="{{categoria_id}}" {{selected}}>

                    {{categoria_nombre}}

                </option>

                {{endfor categorias}}

            </select>

        </div>

        <!-- Orden -->
        <div class="filter-group">

            <label>Ordenar por</label>

            <select name="orden">

                <option value="recientes" {{orden_recientes}}>
                    Más recientes
                </option>

                <option value="nombre_asc" {{orden_nombre_asc}}>
                    Nombre A-Z
                </option>

                <option value="nombre_desc" {{orden_nombre_desc}}>
                    Nombre Z-A
                </option>

                <option value="precio_asc" {{orden_precio_asc}}>
                    Precio menor a mayor
                </option>

                <option value="precio_desc" {{orden_precio_desc}}>
                    Precio mayor a menor
                </option>

                <option value="favoritos" {{orden_favoritos}}>
                    ❤️ Favoritos 
                </option>

            </select>

        </div>

        <!-- Botón -->
        <div class="filter-group">

            <button type="submit" class="btn btn-primary">

                🔎 Buscar

            </button>

        </div>

    </form>

    <br>

    <div class="product-grid">

        {{foreach productos}}

        <article class="product-card">

            <div class="product-image">

                <img src="{{imagen_ruta}}" alt="{{producto_nombre}}">

            </div>

            <div class="product-info">

                <h3>

                    {{producto_nombre}}

                </h3>

                <span class="product-category">

                    {{categoria_nombre}}

                </span>

                <p>

                    {{marca_nombre}}

                </p>

                <p>

                    {{plataforma_nombre}}

                </p>

                <div class="product-price">

                    L {{producto_precio}}

                </div>

                <div class="product-stock">

                    {{producto_stock_texto}}

                </div>

                <br>

                <div class="product-actions">

                    <a href="index.php?page=Carrito_Carrito&action=ADD&producto_id={{producto_id}}"
                        class="btn btn-secondary">

                        Agregar al carrito

                    </a>
                    <br><br>
                    {{if esFavorito}}

                    <a href="index.php?page=Favoritos_Favorito&producto_id={{producto_id}}" class="btn btn-danger">

                        ❤️ Quitar favorito

                    </a>

                    {{endif esFavorito}}

                    {{ifnot esFavorito}}

                    <a href="index.php?page=Favoritos_Favorito&producto_id={{producto_id}}" class="btn btn-primary">

                        🤍 Agregar favorito

                    </a>

                    {{endifnot esFavorito}}

                </div>

            </div>

        </article>

        {{endfor productos}}

    </div>

    <hr>

    <a href="index.php?page=Index" class="btn btn-secondary">

        Regresar

    </a>

</section>