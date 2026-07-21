<section class="depth-1 px-4 mb-4">
    <h2>{{modeDsc}}</h2>
</section > 
<section class="row my-4">
    {{if error_global}}
    <ul class="error">
        {{foreach error_global}}
            <li class="error">{{this}}</li>
        {{endfor error_global}}
    </ul>
    {{endif error_global}}
    {{with resultado}}
    <form 
        class="col-12 col-m-6 offset-m-3 depth-1 px-4 py-4"
        action="index.php?page=Mnt-Resultform&mode={{~mode}}&id={{id}}"
        method="POST"
        novalidate
        >
        <div class="row py-2 align-center">
            <label class="col-12 col-m-2 px-1">Equipo:</label>
            <input type="text" name="equipo_a" required class="col-12 col-m-6" value="{{equipo_a}}">
            <label class="col-12 col-m-2 px-4">Score:</label>
            <input type="number" name="score_a" required class="col-12 col-m-2" value="{{score_a}}">
        </div>
        {{if ~error_equipo_a}}
        <div class="row">
            <ul class="error col-12">
                {{foreach ~error_equipo_a}}
                    <li class="error">{{this}}</li>
                {{endfor ~error_equipo_a}}
            </ul>
        </div>
        {{endif ~error_equipo_a}}
        <div class="row py-2 align-center">
            <label class="col-12 col-m-2 px-1">Equipo:</label>
            <input type="text" name="equipo_b" required class="col-12 col-m-6" value="{{equipo_b}}">
            <label class="col-12 col-m-2 px-4">Score:</label>
            <input type="number" name="score_b" required class="col-12 col-m-2" value="{{score_b}}">
        </div>
        {{if ~error_equipo_b}}
        <div class="row">
            <ul class="error col-12">
                {{foreach ~error_equipo_b}}
                    <li class="error">{{this}}</li>
                {{endfor ~error_equipo_b}}
            </ul>
        </div>
        {{endif ~error_equipo_b}}
        <div class="row py-2 align-center">
            <label class="col-12 col-m-2 px-1">Resumen:</label>
            <textarea name="resumen" required class="col-12 col-m-12">{{resumen}}</textarea>
        </div>
        {{if ~error_resumen}}
        <div class="row">
            <ul class="error col-12">
                {{foreach ~error_resumen}}
                    <li class="error">{{this}}</li>
                {{endfor ~error_resumen}}
            </ul>
        </div>
        {{endif ~error_resumen}}
        <div class="row py-2 align-center my-2 flex-end">
            <input type="hidden" name="id" value="{{id}}">
            <input type="hidden" name="mode" value="{{~mode}}">
            <button type="submit" name="btnGuardar">Guardar</button>
            <button type="button" id="returnBtn" class="mx-4">Cancelar</button>
        </div>
    </form>
    {{endwith resultado}}
</section>
{{if prevalue}}
<section>
    <pre>{{prevalue}}</pre>
</section>
{{endif prevalue}}
<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        document.getElementById("returnBtn").addEventListener("click", (e)=>{
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=Mnt-ResultList");
        });
    });
</script>