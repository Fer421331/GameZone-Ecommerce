<section class="depth-1 px-4 py-4">
    <h2>Esto es una página de demostración</h2>
    <div>
        {{fecha}}
    </div>
    <hr/>
    <h3>Perfil Seleccionado</h3>
    {{with perfil}}
        <table>
            <tr>
                <td>Clase</td>
                <td>{{codigo_curso}} {{desc_curso}}</td>
            </tr>
            <tr>
                <td>Sección</td>
                <td>{{seccion_curso}} ( {{matriculados}}) </td>
            </tr>
            <tr>
                <td>Docente</td>
                <td>{{docente_codigo}} {{docente_curso}}</td>
            </tr>
            <tr>
                <td colspan="2">
                    {{bio_curso}}
                </td>
            </tr>
        </table>
    {{endwith perfil}}
    <hr/>
    <h3>Perfiles Registrados</h3>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Sección</th>
                <th>Matriculados</th>
                <th>Docente</th>
            </tr>
        </thead>
        <tbody>
            {{foreach perfiles}}
            <tr>
                <td>{{codigo_curso}}</td>
                <td>{{desc_curso}}</td>
                <td>{{seccion_curso}}</td>
                <td>{{matriculados}}</td>
                <td>{{docente_codigo}} {{docente_curso}}</td>
            </tr>
            {{endfor perfiles}}
        </tbody>
    </table>
</section>