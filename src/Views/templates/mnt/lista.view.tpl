<section>
    <h2>Gestión de Resultados WC 2026</h2>
</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Equipos</th>
                <th>Score</th>
                <th>Resumen</th>
                <th>
                    <a href="index.php?page=Mnt-ResultForm&mode=INS">Crear</a>
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach resultados}}
            <tr>
                <td>{{equipo_a}} vrs {{equipo_b}}</td>
                <td>{{score_a}} -- {{score_b}}</td>
                <td>{{resumen}}</td>
                <td>
                    <a href="index.php?page=Mnt-ResultForm&mode=DSP&id={{id}}">Mostrar</a><br/>
                    <a href="index.php?page=Mnt-ResultForm&mode=UPD&id={{id}}">Editar</a><br/>
                    <a href="index.php?page=Mnt-ResultForm&mode=DEL&id={{id}}">Borrar</a>
                </td>
            </tr>
            {{endfor resultados}}
        </tbody>
    </table>
</section>