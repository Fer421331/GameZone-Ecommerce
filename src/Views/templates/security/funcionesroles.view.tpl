<h1>Asignar Funciones a Roles</h1>

<section class="WWList">

    <table>

        <thead>
            <tr>
                <th>Código</th>
                <th>Rol</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>

        <tbody>

            {{foreach roles}}

            <tr>

                <td>
                    {{rolescod}}
                </td>

                <td>
                    {{rolesdsc}}
                </td>

                <td>
                    {{rolesest}}
                </td>

                <td>
                    <a href="index.php?page=Security_FuncionRol&rolescod={{rolescod}}">
                        Administrar funciones
                    </a>
                </td>

            </tr>

            {{endfor roles}}

        </tbody>

    </table>

    <hr>
        <a href="index.php?page=Menu_Menu" class="btn btn-secondary">
            Regresar
        </a>
    </hr>

</section>