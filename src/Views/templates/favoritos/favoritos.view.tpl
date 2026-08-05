<section class="catalog-container">

    <div class="catalog-header">

        <h1>❤️ Mis Favoritos</h1>

        <p>
            Tus videojuegos favoritos.
        </p>

        <br>

    </div>

    <div class="catalog-search">

        <input type="text" id="buscarFavorito" placeholder="Buscar favorito..." autocomplete="off">

    </div>
    
    <br>

    <div class="product-grid" id="tablaFavoritos">

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

                    $ {{producto_precio}}

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

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const buscador = document.getElementById("buscarFavorito");
        const productos = document.querySelectorAll("#tablaFavoritos article");

        if (!buscador) {
            return;
        }

        buscador.addEventListener("input", function () {

            const texto = this.value.toLowerCase().trim();

            productos.forEach(function (producto) {

                const contenido = producto.textContent.toLowerCase();

                producto.style.display =
                    contenido.includes(texto)
                        ? ""
                        : "none";

            });

        });

    });
</script>