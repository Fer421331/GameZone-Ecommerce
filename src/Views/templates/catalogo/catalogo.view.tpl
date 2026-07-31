<section class="catalog-container">

    <div class="catalog-header">

        <h1>Catálogo de Videojuegos</h1>

        <p>
            Descubre los mejores videojuegos
            disponibles en GameZone.
        </p>

    </div>

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

                <div class="product-actions">

                    <a href="index.php?page=Carrito_Carrito&action=ADD&producto_id={{producto_id}}" class="btn-primary">

                        Agregar al carrito

                    </a>

                </div>

            </div>

        </article>

        {{endfor productos}}

    </div>

    <hr>
        <a href="index.php?page=Index" class="btn btn-secondary">
            Regresar
        </a>
    </hr>

</section>