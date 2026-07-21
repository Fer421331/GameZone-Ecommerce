<section class="container mt-4">

    {{with usuario}}

    <h2>Administración de Roles del Usuario</h2>

    <h4>{{username}}</h4>

    <p>{{useremail}}</p>

    {{endwith usuario}}

    <hr>

    <div class="row">

        <!-- Roles Asignados -->
        <div class="col-md-6">

            <h3>Roles Asignados</h3>

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>Rol</th>

                        <th>Acción</th>

                    </tr>

                </thead>

                <tbody>

                    {{foreach rolesAsignados}}

                    <tr>

                        <td>{{rolesdsc}}</td>

                        <td>

                            <form method="post" action="index.php?page=Security_RolUsuario&usercod={{~usercod}}">

                                <input type="hidden" name="rolescod" value="{{rolescod}}">

                                <button type="submit" name="btnEliminar" class="btn btn-danger btn-sm">

                                    Inactivar

                                </button>

                            </form>

                        </td>

                    </tr>

                    {{endfor rolesAsignados}}

                </tbody>

            </table>

        </div>

        <!-- Roles Disponibles -->
        <div class="col-md-6">

            <h3>Roles Disponibles</h3>

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>Rol</th>

                        <th>Acción</th>

                    </tr>

                </thead>

                <tbody>

                    {{foreach rolesDisponibles}}

                    <tr>

                        <td>{{rolesdsc}}</td>

                        <td>

                            <form method="post" action="index.php?page=Security_RolUsuario&usercod={{~usercod}}">

                                <input type="hidden" name="rolescod" value="{{rolescod}}">

                                <button type="submit" name="btnAgregar" class="btn btn-success btn-sm">

                                    Asignar

                                </button>

                            </form>

                        </td>

                    </tr>

                    {{endfor rolesDisponibles}}

                </tbody>

            </table>

        </div>

    </div>

    <hr>

    <a class="btn btn-secondary" href="index.php?page=Security_RolesUsuarios">

        Regresar

    </a>

</section> 