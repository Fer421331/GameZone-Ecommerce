<h1>Categorías</h1>

<section class="WWList">

    <a href="index.php?page=Categorias_Categoria&mode=INS" class="btn btn-secondary">
        + Nueva Categoría
    </a>
    <br>
    <br>
    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Fecha Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            {{foreach categorias}}

            <tr>

                <td>{{categoria_id}}</td>
                <td>{{categoria_nombre}}</td>
                <td>{{categoria_descripcion}}</td>
                <td>{{categoria_estado}}</td>
                <td>{{categoria_fecha_creacion}}</td>

                <td>

                    <div class="acciones">

                        <a href="index.php?page=Categorias_Categoria&mode=DSP&categoria_id={{categoria_id}}"
                            class="btn btn-info">
                            Ver
                        </a>

                        <a href="index.php?page=Categorias_Categoria&mode=UPD&categoria_id={{categoria_id}}"
                            class="btn btn-warning">
                            Editar
                        </a>

                        <a href="index.php?page=Categorias_Categoria&mode=DEL&categoria_id={{categoria_id}}"
                            class="btn btn-danger">
                            Eliminar
                        </a>

                    </div>

                </td>

            </tr>

            {{endfor categorias}}

        </tbody>

    </table>

    <hr>
        <a href="index.php?page=Menu_Menu" class="btn btn-secondary">
            Regresar
        </a>
    </hr>

</section>