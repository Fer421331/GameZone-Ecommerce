<h1>{{FormTitle}}</h1>

<form action="index.php?page=RutasEntrega_RutaEntrega&mode={{mode}}&id_ruta={{id_ruta}}" method="POST">

    <input type="hidden" name="ruta_xss_token" value="{{ruta_xss_token}}">

    <label>ID Ruta</label>

    <input type="text" name="id_ruta" value="{{id_ruta}}" readonly>

    <br><br>

    <label>Origen</label>

    <input type="text" name="origen" value="{{origen}}" {{readonly}}>

    <span>{{origen_error}}</span>

    <br><br>

    <label>Destino</label>

    <input type="text" name="destino" value="{{destino}}" {{readonly}}>

    <span>{{destino_error}}</span>

    <br><br>

    <label>Distancia (Km)</label>

    <input type="text" name="distancia_km" value="{{distancia_km}}" {{readonly}}>

    <span>{{distancia_km_error}}</span>

    <br><br>

    <label>Duración (Min)</label>

    <input type="text" name="duracion_min" value="{{duracion_min}}" {{readonly}}>

    <span>{{duracion_min_error}}</span>

    <br><br>

    <label>Estado</label>

    <select name="estado" {{readonly}}>

        <option value="ACT" {{estado_act}}>
            Activo
        </option>

        <option value="INA" {{estado_ina}}>
            Inactivo
        </option>

    </select>

    <span>{{estado_error}}</span>

    <br><br>

    <div class="buttons">

        {{if showCommitBtn}}

        <input class="btn-back" type="submit" value="Confirmar">

        {{endif showCommitBtn}}

        <a class="btn-back" href="index.php?page=RutasEntrega_RutasEntrega">
            Regresar
        </a>

    </div>

</form>