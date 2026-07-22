<h1>{{FormTitle}}</h1>

<form action="index.php?page=Categorias_Categoria&mode={{mode}}&categoria_id={{categoria_id}}" method="POST">

    <input type="hidden" name="categoria_xss_token" value="{{categoria_xss_token}}">

    <label>ID Categoría</label>

    <input type="text" name="categoria_id" value="{{categoria_id}}" readonly>

    <br><br>

    <label>Nombre</label>

    <input type="text" name="categoria_nombre" value="{{categoria_nombre}}" {{readonly}}>

    <span>{{categoria_nombre_error}}</span>

    <br><br>

    <label>Descripción</label>

    <textarea name="categoria_descripcion" {{readonly}}>{{categoria_descripcion}}</textarea>

    <br><br>

    <label>Estado</label>

    <select name="categoria_estado" {{disabled}}>

        <option value="ACT" {{estado_act}}>
            Activo
        </option>

        <option value="INA" {{estado_ina}}>
            Inactivo
        </option>

    </select>

    <span>{{categoria_estado_error}}</span>

    <br><br>

    <div class="buttons">

        {{if showCommitBtn}}

        <input class="btn-back" type="submit" value="Confirmar">

        {{endif showCommitBtn}}

        <a class="btn-back" href="index.php?page=Categorias_Categorias">
            Regresar
        </a>

    </div>

</form>