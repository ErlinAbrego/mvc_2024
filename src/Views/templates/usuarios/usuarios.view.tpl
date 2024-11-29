<link rel="stylesheet" href="public/css/table.css">
<h1>Listado de Usuarios</h1>
<section class="wwerl">
    <table>
        <thead>
            <tr>
                {{if usercod_enable}}
                <th>Código</th>
                {{endif usercod_enable}}
                {{if Email_enable}}
                <th>Email</th>
                {{endif Email_enable}}
                <th>Nombre Usuario</th>
                {{if pswd_enable}}
                <th>Contraseña</th>
                {{endif pswd_enable}}
                <th>Fecha de Registro</th>
                <th>Estado Contraseña</th>
                <th>Expiración Contraseña</th>
                <th>Estado</th>
                {{if cdgAct_enable}}
                <th>Codigo de Activación</th>
                {{endif cdgAct_enable}}
                <th>Cambio de Contraseña</th>
                {{if tipoUsuario_enable}}
                <th>Tipo de Usuario</th>
                {{endif tipoUsuario_enable}}
                <th>
                    {{if INS_enable}}
                    <a href="index.php?page=Usuarios-UsuariosForm&mode=INS"><i class="fa-solid fa-user-plus"
                            style="color: #ffffff;"></i></a>
                    {{endif INS_enable}}
                </th>
                
            </tr>
        </thead>
        <tbody>
            {{foreach usuarios}}
            <tr>
                {{if ~usercod_enable}}
                <td>{{usercod}}</td>
                {{endif ~usercod_enable}}

                {{if ~Email_enable}}
                <td>{{useremail}}</td>
                {{endif ~Email_enable}}
                
                <td>{{username}}</td>
                {{if ~pswd_enable}}
                <td>{{userpswd}}</td>
                {{endif ~pswd_enable}}
                <td>{{userfching}}</td>
                <td>{{estado_dsc}}</td>
                <td>{{userpswdexp}}</td>
                <td>{{estado_dsc}}</td>
                {{if ~cdgAct_enable}}
                <td>{{useractcod}}</td>
                {{endif ~cdgAct_enable}}
                <td>{{userpswdchg}}</td>
                {{if ~tipoUsuario_enable}}
                <td>{{usertipo}}</td>
                {{endif ~tipoUsuario_enable}}
                <td "Acciones" style="display:flex; gap:1rem; justify-content:center; align-items:center">

                    {{if ~UPD_enable}}
                    <a href="index.php?page=Usuarios-UsuariosForm&mode=UPD&usercod={{usercod}}"><i class="fas fa-user-pen" style="color: #16a34a;"></i></a>
                    {{endif ~UPD_enable}}

                    {{if ~DEL_enable}}
                    <a href="index.php?page=Usuarios-UsuariosForm&mode=DEL&usercod={{usercod}}"><i class="fas fa-trash-can" style="color: #16a34a;"></i></a>
                    {{endif ~DEL_enable}}

                    <a href="index.php?page=Usuarios-UsuariosForm&mode=DSP&usercod={{usercod}}"><i class="fas fa-search"
                            style="color: #16a34a;"> </i></a>
                </td>
            </tr>
            {{endfor usuarios}}
        </tbody>
    </table>
</section>