<h1>
    {{FormTitle}}
</h1>



<form action="index.php?page=Plataformas_Plataforma&mode={{mode}}&plataforma_id={{plataforma_id}}" method="POST">


    <input type="hidden" name="plataforma_csrf_token" value="{{plataforma_csrf_token}}">



    <input type="hidden" name="plataforma_id" value="{{plataforma_id}}">





    <label>
        ID de plataforma
    </label>


    <input type="text" value="{{plataforma_id}}" readonly>





    <br><br>





    <label>
        Nombre
    </label>


    <input type="text" name="plataforma_nombre" maxlength="100" value="{{plataforma_nombre}}" {{readonly}}>



    <span class="error">

        {{plataforma_nombre_error}}

    </span>





    <br><br>





    <label>
        Descripción
    </label>



    <textarea name="plataforma_descripcion" rows="5" {{readonly}}>{{plataforma_descripcion}}</textarea>



    <span class="error">

        {{plataforma_descripcion_error}}

    </span>






    <br><br>





    <label>
        Estado
    </label>


    <select name="plataforma_estado" {{disabled}}>


        <option value="ACT" {{estado_act}}>

            Activo

        </option>



        <option value="INA" {{estado_ina}}>

            Inactivo

        </option>



    </select>



    <span class="error">

        {{plataforma_estado_error}}

    </span>








    {{if isDelete}}


    <p>

        <strong>

            La plataforma será desactivada.
            Sus productos conservarán la información histórica.

        </strong>


    </p>


    {{endif isDelete}}








    <br><br>





    <div class="buttons">


        {{if showCommitBtn}}


        <input class="btn btn-secondary" type="submit" value="Confirmar">


        {{endif showCommitBtn}}



    </div>



</form>






<hr>



<a href="index.php?page=Plataformas_Plataformas" class="btn btn-secondary">

    Regresar

</a>



</hr>