<div class="page-shell">

    <h1>
        {{menu_titulo}}
    </h1>

    <section class="WWList">

        <div class="category-grid">

            {{foreach menu}}

            <div class="category-card glow">
                <h2>
                    {{titulo}}
                </h2>
                <p>
                    {{descripcion}}
                </p>
                <a href="{{url}}" class="btn">
                    Ingresar
                </a>
            </div>

            {{endfor menu}}

        </div>

    </section>

</div>