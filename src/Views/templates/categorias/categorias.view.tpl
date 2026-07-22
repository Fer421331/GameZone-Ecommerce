<h1>Work With - Categorías</h1>

<section class="WWList">

    <a href="index.php?page=Categorias_Categoria&mode=INS" class="btn-primary">
        + Nueva Categoría
    </a>

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

    <br>

    <a href="index.php" class="btn-back">
        Regresar al Inicio
    </a>

</section>