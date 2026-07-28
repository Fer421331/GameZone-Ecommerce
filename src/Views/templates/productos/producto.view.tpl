<h1>{{FormTitle}}</h1>

<form
    action="index.php?page=Productos_Producto&mode={{mode}}&producto_id={{producto_id}}"
    method="POST"
>
    <input
        type="hidden"
        name="producto_csrf_token"
        value="{{producto_csrf_token}}"
    >

    <input
        type="hidden"
        name="producto_id"
        value="{{producto_id}}"
    >

    <label>ID del producto</label>
    <input
        type="text"
        value="{{producto_id}}"
        readonly
    >

    <br><br>

    <label>SKU</label>
    <input
        type="text"
        name="producto_sku"
        maxlength="40"
        value="{{producto_sku}}"
        {{readonly}}
    >
    <span class="error">
        {{producto_sku_error}}
    </span>

    <br><br>

    <label>Nombre</label>
    <input
        type="text"
        name="producto_nombre"
        maxlength="150"
        value="{{producto_nombre}}"
        {{readonly}}
    >
    <span class="error">
        {{producto_nombre_error}}
    </span>

    <br><br>

    <label>Categoría</label>
    <select name="categoria_id" {{disabled}}>
        <option value="">
            Seleccione una categoría
        </option>

        {{foreach categorias}}
        <option
            value="{{categoria_id}}"
            {{selected}}
        >
            {{categoria_nombre}}
        </option>
        {{endfor categorias}}
    </select>

    <span class="error">
        {{categoria_id_error}}
    </span>

    <br><br>

    <label>Marca</label>
    <select name="marca_id" {{disabled}}>
        <option value="">
            Seleccione una marca
        </option>

        {{foreach marcas}}
        <option
            value="{{marca_id}}"
            {{selected}}
        >
            {{marca_nombre}}
        </option>
        {{endfor marcas}}
    </select>

    <span class="error">
        {{marca_id_error}}
    </span>

    <br><br>

    <label>Plataforma</label>
    <select name="plataforma_id" {{disabled}}>
        <option value="">
            Sin plataforma específica
        </option>

        {{foreach plataformas}}
        <option
            value="{{plataforma_id}}"
            {{selected}}
        >
            {{plataforma_nombre}}
        </option>
        {{endfor plataformas}}
    </select>

    <span class="error">
        {{plataforma_id_error}}
    </span>

    <br><br>

    <label>Descripción</label>
    <textarea
        name="producto_descripcion"
        rows="5"
        {{readonly}}
    >{{producto_descripcion}}</textarea>

    <span class="error">
        {{producto_descripcion_error}}
    </span>

    <br><br>

    <label>Costo (L)</label>
    <input
        type="number"
        name="producto_costo"
        min="0"
        step="0.01"
        value="{{producto_costo}}"
        {{readonly}}
    >

    <span class="error">
        {{producto_costo_error}}
    </span>

    <br><br>

    <label>Precio de venta (L)</label>
    <input
        type="number"
        name="producto_precio"
        min="0.01"
        step="0.01"
        value="{{producto_precio}}"
        {{readonly}}
    >

    <span class="error">
        {{producto_precio_error}}
    </span>

    <br><br>

    <label>Stock</label>
    <input
        type="number"
        name="producto_stock"
        min="0"
        step="1"
        value="{{producto_stock}}"
        {{readonly}}
    >

    <span class="error">
        {{producto_stock_error}}
    </span>

    <br><br>

    <label>Visible en el catálogo web</label>
    <select
        name="producto_activo_web"
        {{disabled}}
    >
        <option value="ACT" {{web_act}}>
            Publicado
        </option>

        <option value="INA" {{web_ina}}>
            Oculto
        </option>
    </select>

    <span class="error">
        {{producto_activo_web_error}}
    </span>

    <br><br>

    <label>Estado</label>
    <select
        name="producto_estado"
        {{disabled}}
    >
        <option value="ACT" {{estado_act}}>
            Activo
        </option>

        <option value="INA" {{estado_ina}}>
            Inactivo
        </option>
    </select>

    <span class="error">
        {{producto_estado_error}}
    </span>

    {{if isDelete}}
    <p>
        <strong>
            El producto será desactivado y ocultado del
            catálogo. Su información no se eliminará para
            conservar el historial de ventas.
        </strong>
    </p>
    {{endif isDelete}}

    <br><br>

    <div class="buttons">
        {{if showCommitBtn}}
        <input
            class="btn-primary"
            type="submit"
            value="Confirmar"
        >
        {{endif showCommitBtn}}

        <a
            class="btn-back"
            href="index.php?page=Productos_Productos"
        >
            Regresar
        </a>
    </div>
</form>