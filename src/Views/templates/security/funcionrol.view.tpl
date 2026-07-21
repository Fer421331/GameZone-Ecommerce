<section class="container mt-4">

    {{with rol}}
    <h2>Administrar Funciones del Rol</h2>
    <h4>{{rolesdsc}}</h4>
    {{endwith rol}}

    <hr>

    <div class="row">

        <!-- Funciones Asignadas -->
        <div class="col-md-6">

            <h3>Funciones Asignadas</h3>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    {{foreach funcionesAsignadas}}

                    <tr>
                        <td>{{fncod}}</td>
                        <td>{{fndsc}}</td>

                        <td>

                            <form method="post" action="index.php?page=Security_FuncionRol&rolescod={{~rolescod}}">

                                <input type="hidden" name="fncod" value="{{fncod}}">

                                <button type="submit" name="btnEliminar" class="btn btn-danger btn-sm">

                                    Quitar

                                </button>

                            </form>

                        </td>

                    </tr>

                    {{endfor funcionesAsignadas}}

                </tbody>

            </table>

        </div>


        <!-- Funciones Disponibles -->

        <div class="col-md-6">

            <h3>Funciones Disponibles</h3>

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    {{foreach funcionesDisponibles}}

                    <tr>

                        <td>{{fncod}}</td>

                        <td>{{fndsc}}</td>

                        <td>

                            <form method="post" action="index.php?page=Security_FuncionRol&rolescod={{~rolescod}}">

                                <input type="hidden" name="fncod" value="{{fncod}}">

                                <button type="submit" name="btnAgregar" class="btn btn-success btn-sm">

                                    Agregar

                                </button>

                            </form>

                        </td>

                    </tr>

                    {{endfor funcionesDisponibles}}

                </tbody>

            </table>

        </div>

    </div>

    <hr>

    <a href="index.php?page=Security_FuncionesRoles" class="btn btn-secondary">

        Regresar

    </a>

</section>