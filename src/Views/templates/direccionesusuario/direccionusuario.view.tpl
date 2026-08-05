<section class="container">


<h1>{{FormTitle}}</h1>


<hr>



<form method="post"
      action="index.php?page=DireccionesUsuario_DireccionUsuario&mode={{mode}}&direccion_id={{direccion_id}}">


    <div class="mb-3">


        <label>
            Alias
        </label>


        <input type="text"
               name="direccion_alias"
               class="form-control"
               value="{{direccion_alias}}"
               {{readonly}}>


    </div>





    <div class="mb-3">


        <label>
            Receptor
        </label>


        <input type="text"
               name="direccion_receptor"
               class="form-control"
               value="{{direccion_receptor}}"
               {{readonly}}>


        <span class="text-danger">

            {{direccion_receptor_error}}

        </span>


    </div>





    <div class="mb-3">


        <label>
            Teléfono
        </label>


        <input type="text"
               name="direccion_telefono"
               class="form-control"
               value="{{direccion_telefono}}"
               {{readonly}}>


        <span class="text-danger">

            {{direccion_telefono_error}}

        </span>


    </div>







    <div class="mb-3">


        <label>
            Departamento
        </label>


        <input type="text"
               name="direccion_departamento"
               class="form-control"
               value="{{direccion_departamento}}"
               {{readonly}}>


        <span class="text-danger">

            {{direccion_departamento_error}}

        </span>


    </div>







    <div class="mb-3">


        <label>
            Ciudad
        </label>


        <input type="text"
               name="direccion_ciudad"
               class="form-control"
               value="{{direccion_ciudad}}"
               {{readonly}}>


        <span class="text-danger">

            {{direccion_ciudad_error}}

        </span>


    </div>







    <div class="mb-3">


        <label>
            Ruta de entrega
        </label>



        <select name="id_ruta"
                class="form-control"
                {{readonly}}>



            <option value="">
                Seleccione una ruta
            </option>



            {{foreach rutas}}


            <option value="{{id_ruta}}" {{selected}}>

                {{origen}}

                →

                {{destino}}

                ({{distancia_km}} km)


            </option>



            {{endfor rutas}}



        </select>



        <span class="text-danger">

            {{id_ruta_error}}

        </span>


    </div>








    <div class="mb-3">


        <label>
            Dirección exacta
        </label>



        <textarea name="direccion_detalle"
                  class="form-control"
                  {{readonly}}>{{direccion_detalle}}</textarea>



        <span class="text-danger">

            {{direccion_detalle_error}}

        </span>


    </div>








    <div class="mb-3">


        <label>
            Referencia
        </label>



        <textarea name="direccion_referencia"
                  class="form-control"
                  {{readonly}}>{{direccion_referencia}}</textarea>


    </div>








    <div class="form-check small">


        <input type="checkbox"
               class="form-check-input"
               name="direccion_predeterminada"
               value="1"
               {{direccion_predeterminada_checked}}
               {{readonly}}>


        <label class="form-check-label">

            Usar como dirección principal

        </label>


    </div>


    <br>


    {{if showCommitBtn}}


        <button class="btn btn-primary">

            Guardar

        </button>


    {{endif showCommitBtn}}


    <a href="index.php?page=DireccionesUsuario_DireccionesUsuarios"
       class="btn btn-secondary">

        Regresar

    </a>




</form>


</section>