<section class="catalog-container">

    <div class="catalog-header">

        <h1>❤️ Mis Favoritos</h1>

        <p>
            Tus videojuegos favoritos.
        </p>

    </div>

    <br>

    <div class="product-grid">

        {{foreach favoritos}}

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

                    Disponible

                </div>

                <br>

                <div class="product-actions">

                    <a href="index.php?page=Carrito_Carrito&action=ADD&producto_id={{producto_id}}"
                        class="btn btn-secondary">

                        Agregar al carrito

                    </a>

                    <a href="index.php?page=Favoritos_Favorito&producto_id={{producto_id}}" class="btn btn-danger">

                        ❤️ Quitar favorito

                    </a>

                </div>

            </div>

        </article>

        {{endfor favoritos}}

    </div>

    <hr>

    <a href="index.php?page=Catalogo_Catalogo" class="btn btn-secondary">

        Regresar al catálogo

    </a>

</section>