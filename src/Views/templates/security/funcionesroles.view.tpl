<h1>Roles del Sistema</h1>

<table>

    <tr>
        <th>Código</th>
        <th>Descripción</th>
        <th>Estado</th>
        <th>Acción</th>
    </tr>

    {{foreach roles}}

    <tr>

        <td>{{rolescod}}</td>

        <td>{{rolesdsc}}</td>

        <td>{{rolesest}}</td>

        <td>

            <a href="index.php?page=Security_FuncionRol&rolescod={{rolescod}}">
                Administrar Funciones
            </a>

        </td>

    </tr>

    {{endfor roles}}

</table>