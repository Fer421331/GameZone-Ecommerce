<h1>
    {{marca_nombre}}
</h1>


<form method="POST" action="index.php?page=Marcas_Marca&mode={{mode}}&marca_id={{marca_id}}">


    <input type="hidden" name="csrf" value="{{csrf}}">


    <input type="hidden" name="marca_id" value="{{marca_id}}">



    <label>
        ID
    </label>

    <input type="text" value="{{marca_id}}" readonly>



    <br><br>



    <label>
        Nombre
    </label>


    <input type="text" name="marca_nombre" value="{{marca_nombre}}" maxlength="100">



    <span class="error">
        {{error}}
    </span>



    <br><br>



    <label>
        Descripción
    </label>


    <textarea name="marca_descripcion" rows="5">{{marca_descripcion}}</textarea>




    <br><br>



    <label>
        Estado
    </label>



    <select name="marca_estado">


        <option value="ACT" {{estado_act}}>

            Activo

        </option>



        <option value="INA" {{estado_ina}}>

            Inactivo

        </option>



    </select>




    <br><br>



    {{ifnot mode_DSP}}

    <input type="submit" class="btn btn-secondary" value="Confirmar">

    {{endifnot mode_DSP}}



</form>



<hr>


<a href="index.php?page=Marcas_Marcas" class="btn btn-secondary">

    Regresar

</a>