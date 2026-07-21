<h1>Work With - Rutas de Entrega</h1>

<section class="WWList">

    <a href="index.php?page=RutasEntrega_RutaEntrega&mode=INS" class="btn-primary">
        + Nueva Ruta
    </a>

    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Distancia (Km)</th>
                <th>Duración (Min)</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            {{foreach rutasentrega}}

            <tr>

                <td>{{id_ruta}}</td>
                <td>{{origen}}</td>
                <td>{{destino}}</td>
                <td>{{distancia_km}}</td>
                <td>{{duracion_min}}</td>
                <td>{{estado}}</td>

                <td>

                    <div class="acciones">

                        <a href="index.php?page=RutasEntrega_RutaEntrega&mode=DSP&id_ruta={{id_ruta}}"
                            class="btn btn-info">
                            Ver
                        </a>

                        <a href="index.php?page=RutasEntrega_RutaEntrega&mode=UPD&id_ruta={{id_ruta}}"
                            class="btn btn-warning">
                            Editar
                        </a>

                        <a href="index.php?page=RutasEntrega_RutaEntrega&mode=DEL&id_ruta={{id_ruta}}"
                            class="btn btn-danger">
                            Eliminar
                        </a>

                    </div>

                </td>
            </tr>

            {{endfor rutasentrega}}

        </tbody>

    </table>

    <br>

    <a href="index.php" class="btn-back">
        Regresar al Inicio
    </a>

</section>