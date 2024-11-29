<link rel="stylesheet" href="public/css/table.css">
<h1>Listado de Roles</h1>
<section class="wwerl">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>
                    {{if INS_enable}}
                    <a href="index.php?page=Roles-RolesForm&mode=INS"><i class="fa-solid fa-square-plus" style="color: #ffffff;"></i></a>
                    {{endif INS_enable}}
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach roles}}
                <tr>
                    <td>{{rolescod}}</td>
                    <td>{{rolesdsc}}</td>
                    <td>{{estado_dsc}}</td>
                    <td style="display:flex; gap:1rem; justify-content:center; align-items:center">
                        {{if ~UPD_enable}}
                        <a href="index.php?page=Roles-RolesForm&mode=UPD&rolescod={{rolescod}}"><i class="fa-solid fa-file-pen" style="color: #16a34a;"></i></a>
                        {{endif ~UPD_enable}}
                        {{if ~DEL_enable}}
                        <a href="index.php?page=Roles-RolesForm&mode=DEL&rolescod={{rolescod}}"><i class="fas fa-trash-can" style="color: #16a34a;"></i></i></a>
                        {{endif ~DEL_enable}}
                        <a href="index.php?page=Roles-RolesForm&mode=DSP&rolescod={{rolescod}}"><i class="fas fa-search" style="color: #16a34a;"></i></a>
                    </td>
                </tr>
            {{endfor roles}}
        </tbody>
    </table>
</section>
