<h1>Roles</h1>

<section class="grid">
    <div class="row">
        <form class="col-12 col-m-8" action="index.php" method="get">
            <div class="flex align-center">
                <div class="col-8 row">

                    <input type="hidden" name="page" value="Security_Roles">

                    <label class="col-3" for="partialName">
                        Descripción
                    </label>

                    <input class="col-9"
                        type="text"
                        name="partialName"
                        id="partialName"
                        value="{{partialName}}" />


                    <label class="col-3" for="status">
                        Estado
                    </label>

                    <select class="col-9"
                        name="status"
                        id="status">

                        <option value="">
                            Todos
                        </option>

                        <option value="ACT">
                            Activo
                        </option>

                        <option value="INA">
                            Inactivo
                        </option>

                    </select>

                </div>


                <div class="col-4 align-end">
                    <button type="submit">
                        Filtrar
                    </button>
                </div>
                <br>
            </div>
        </form>
    </div>
</section>


<section class="WWList">

    <table>

        <thead>

            <tr>

                <th>
                    Código
                </th>

                <th>
                    Descripción
                </th>

                <th>
                    Estado
                </th>

                <th>
                    <a href="index.php?page=Security_Rol&mode=INS" class="btn btn-secondary">
                        Nuevo
                    </a>
                </th>

            </tr>

        </thead>


        <tbody>

            {{foreach roles}}

            <tr>

                <td>
                    {{rolescod}}
                </td>


                <td>
                    <a href="index.php?page=Security_Rol&mode=DSP&rolescod={{rolescod}}" class="btn btn-secondary">
                        {{rolesdsc}}
                    </a>

                </td>


                <td class="center">
                    {{rolesest}}
                </td>


                <td class="center">

                    <a href="index.php?page=Security_Rol&mode=UPD&rolescod={{rolescod}}" class="btn btn-secondary">
                        Editar
                    </a>


                    <a href="index.php?page=Security_Rol&mode=DEL&rolescod={{rolescod}}" class="btn btn-secondary">
                        Eliminar
                    </a>

                </td>

            </tr>

            {{endfor roles}}

        </tbody>

    </table>


    {{pagination}}


    <hr>
        <a href="index.php?page=Menu_Menu" class="btn btn-secondary">
            Regresar
        </a>
    </hr>

</section>