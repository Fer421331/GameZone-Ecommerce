<h1>Bitácora</h1>

<section class="WWList">

    <table>

        <thead>

            <tr>

                <th>Fecha</th>
                <th>Usuario</th>
                <th>Módulo</th>
                <th>Acción</th>
                <th>Observación</th>

            </tr>

        </thead>

        <tbody>

            {{foreach bitacora}}

            <tr>

                <td>{{bitacorafch}}</td>

                <td>{{username}}</td>

                <td>{{bitprograma}}</td>

                <td>{{bitdescripcion}}</td>

                <td>{{bitobservacion}}</td>

            </tr>

            {{endfor bitacora}}

        </tbody>

    </table>

    <hr>

    <a href="index.php?page=Menu_Menu" class="btn btn-secondary">
        Regresar
    </a>

    </hr>

</section>