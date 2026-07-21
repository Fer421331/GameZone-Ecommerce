<h1>Usuarios del Sistema</h1>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Correo</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Tipo</th>
            <th>Acción</th>
        </tr>
    </thead>

    <tbody>
        {{foreach usuarios}}
        <tr>
            <td>{{usercod}}</td>
            <td>{{useremail}}</td>
            <td>{{username}}</td>
            <td>{{userest}}</td>
            <td>{{usertipo}}</td>

            <td>
                <a href="index.php?page=Security_RolUsuario&usercod={{usercod}}">
                    Administrar Roles
                </a>
            </td>
        </tr>
        {{endfor usuarios}}
    </tbody>

</table>