<link rel="stylesheet" href="public/css/table.css">
<h1 >Listado de Funciones</h1>
<section class="wwerl">
    <table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Tipo</th>
            <th><a href="index.php?page=Funciones-FuncionesForm&mode=INS"><i class="fa-solid fa-circle-plus" style="color: #ffffff;"></i></a></th>
        </tr>
    </thead>
    <tbody>
        {{foreach funciones}}
            <tr>
                <td>{{fncod}}</td>
                <td>{{fndsc}}</td>
                <td>{{estado_dsc}}</td>
                <td>{{fntyp}}</td>
                <td style="display:flex; gap:1rem; justify-content:center; align-items:center">
                    <a href="index.php?page=Funciones-FuncionesForm&mode=UPD&fncod={{fncod}}"><i class="fa-duotone fa-solid fa-pen-to-square" style="color: #16a34a;"></i></i></a>
                    <a href="index.php?page=Funciones-FuncionesForm&mode=DEL&fncod={{fncod}}"><i class="fas fa-trash-can" style="color: #16a34a;"></i></a>
                    <a href="index.php?page=Funciones-FuncionesForm&mode=DSP&fncod={{fncod}}"><i class="fas fa-search" style="color: #16a34a;"></i></a>
                </td>
            </tr>
        {{endfor funciones}}
    </tbody>
    </table>
</section>