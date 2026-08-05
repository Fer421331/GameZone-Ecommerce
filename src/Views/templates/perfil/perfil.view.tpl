<section class="container">

    <h1>Mi Perfil</h1>

    <hr>


    {{if error}}

    <div class="alert alert-danger">
        {{error}}
    </div>

    {{endif error}}



    <div class="card">

        <div class="card-body">


            <form method="post">

                <input type="hidden" name="accion" value="perfil">


                <div class="mb-3">

                    <label>
                        Usuario
                    </label>

                    <input type="text" name="username" class="form-control" value="{{username}}">

                </div>



                <div class="mb-3">

                    <label>
                        Correo electrónico
                    </label>

                    <input type="email" name="useremail" class="form-control" value="{{useremail}}">

                </div>



                <button class="btn btn-primary">
                    Guardar cambios
                </button>


            </form>


        </div>

    </div>



    <hr>



    <h3>Resumen</h3>



    <div class="row">


        <div class="col-md-4">

            <div class="alert alert-info">

                Compras:
                <strong>{{compras}}</strong>

            </div>

        </div>



        <div class="col-md-4">

            <div class="alert alert-warning">

                Favoritos:
                <strong>{{favoritos}}</strong>

            </div>

        </div>



        <div class="col-md-4">

            <div class="alert alert-success">

                Carrito:
                <strong>{{carrito}}</strong>

            </div>

        </div>


    </div>



    <hr>



    <section class="depth-1 py-5">


        <h2>
            Cambiar contraseña
        </h2>



        {{if errorPassword}}

        <div class="alert alert-danger">
            {{errorPassword}}
        </div>

        {{endif errorPassword}}



        {{if successPassword}}

        <div class="alert alert-success">
            {{successPassword}}
        </div>

        {{endif successPassword}}



        <form method="post">


            <input type="hidden" name="accion" value="password">



            <div class="mb-3">

                <label>
                    Contraseña actual
                </label>


                <input type="password" name="passwordActual" class="form-control" required>

            </div>




            <div class="mb-3">

                <label>
                    Nueva contraseña
                </label>


                <input type="password" name="passwordNueva" class="form-control" required>

            </div>




            <div class="mb-3">

                <label>
                    Confirmar nueva contraseña
                </label>


                <input type="password" name="passwordConfirmar" class="form-control" required>

            </div>




            <button class="btn btn-primary" type="submit">

                Cambiar contraseña

            </button>



        </form>



    </section>



    <hr>



    <a href="index.php?page=Index" class="btn btn-secondary">

        Regresar

    </a>



</section>