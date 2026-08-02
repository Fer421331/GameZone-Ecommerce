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



                <div class="mb-3">

                    <label>
                        Tipo Usuario
                    </label>

                    <input class="form-control" readonly value="{{usertipo}}">

                </div>



                <div class="mb-3">

                    <label>
                        Rol
                    </label>

                    <input class="form-control" readonly value="{{rolesdsc}}">

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
                <strong>
                    {{compras}}
                </strong>

            </div>

        </div>



        <div class="col-md-4">

            <div class="alert alert-warning">

                Favoritos:
                <strong>
                    {{favoritos}}
                </strong>

            </div>

        </div>



        <div class="col-md-4">

            <div class="alert alert-success">

                Carrito:
                <strong>
                    {{carrito}}
                </strong>

            </div>

        </div>



    </div>

    <hr>
        <a href="index.php?page=Index" class="btn btn-secondary">
            Regresar
        </a>
    </hr>

</section>