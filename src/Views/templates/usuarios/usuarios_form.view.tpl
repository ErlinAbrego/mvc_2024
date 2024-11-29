<link rel="stylesheet" href="public/css/styles.css">
<h1>{{modes_dsc}}</h1>
<section>
    <form action="index.php?page=Usuarios-UsuariosForm&mode={{mode}}&usercod={{usercod}}" method="post">
        {{with usuario}}
        <div>
            <label for="usercod">Código</label>
            <input type="text" name="usercod" id="usercod" value="{{usercod}}" readonly>
            <input type="hidden" name="xssToken" value="{{~xssToken}}">
        </div>
        <div>
            <label for="useremail">Email</label>
            <input type="text" name="useremail" id="useremail" value="{{useremail}}" {{~readonly}}>
            {{if ~useremail_haserror}}
                <div class="error">
                    <ul>
                    {{foreach ~useremail_error}}
                        <li>{{this}}</li>
                    {{endfor ~useremail_error}}
                    </ul>
                </div>
            {{endif ~useremail_haserror}}
        </div>
        <div>
            <label for="username">Nombre de Usuario</label>
            <input type="text" name="username" id="username" value="{{username}}" {{~readonly}}>
            {{if ~username_haserror}}
                <div class="error">
                    <ul>
                    {{foreach ~username_error}}
                        <li>{{this}}</li>
                    {{endfor ~username_error}}
                    </ul>
                </div>
            {{endif ~username_haserror}}
        </div>
        <div>
            <label for="userpswd">Contraseña</label>
            <input type="password" name="userpswd" id="userpswd" value="{{userpswd}}" {{~readonly}}>
            {{if ~userpswd_haserror}}
                <div class="error">
                    <ul>
                    {{foreach ~userpswd_error}}
                        <li>{{this}}</li>
                    {{endfor ~userpswd_error}}
                    </ul>
                </div>
            {{endif ~userpswd_haserror}}
        </div>
        <div>
            <label for="userfching">Fecha de Registro</label>
            <input type="datetime-local" name="userfching" id="userfching" value="{{userfching}}" {{~readonly}}>
            {{if ~userfching_haserror}}
                <div class="error">
                    <ul>
                    {{foreach ~userfching_error}}
                        <li>{{this}}</li>
                    {{endfor ~userfching_error}}
                    </ul>
                </div>
            {{endif ~userfching_haserror}}
        </div>
        <div>
            <label for="userpswdest">Estado Contraseña</label>
            <input type="text" name="userpswdest" id="userpswdest" value="{{userpswdest}}" {{~readonly}}>
            {{if ~userpswdest_haserror}}
                <div class="error">
                    <ul>
                    {{foreach ~userpswdest_error}}
                        <li>{{this}}</li>
                    {{endfor ~userpswdest_error}}
                    </ul>
                </div>
            {{endif ~userpswdest_haserror}}
        </div>
        <div>
            <label for="userpswdexp">Expiración Contraseña</label>
            <input type="datetime-local" name="userpswdexp" id="userpswdexp" value="{{userpswdexp}}" {{~readonly}}>
            {{if ~userpswdexp_haserror}}
                <div class="error">
                    <ul>
                    {{foreach ~userpswdexp_error}}
                        <li>{{this}}</li>
                    {{endfor ~userpswdexp_error}}
                    </ul>
                </div>
            {{endif ~userpswdexp_haserror}}
        </div>
        <div>
            <label for="userest">Estado</label>
            <input type="text" name="userest" id="userest" value="{{userest}}" {{~readonly}}>
            {{if ~userest_haserror}}
                <div class="error">
                    <ul>
                    {{foreach ~userest_error}}
                        <li>{{this}}</li>
                    {{endfor ~userest_error}}
                    </ul>
                </div>
            {{endif ~userest_haserror}}
        </div>
        <div>
            <label for="useractcod">Código de Activación</label>
            <input type="text" name="useractcod" id="useractcod" value="{{useractcod}}" {{~readonly}}>
            {{if ~useractcod_haserror}}
                <div class="error">
                    <ul>
                    {{foreach ~useractcod_error}}
                        <li>{{this}}</li>
                    {{endfor ~useractcod_error}}
                    </ul>
                </div>
            {{endif ~useractcod_haserror}}
        </div>
        <div>
            <label for="userpswdchg">Cambio de Contraseña</label>
            <input type="text" name="userpswdchg" id="userpswdchg" value="{{userpswdchg}}" {{~readonly}}>
            {{if ~userpswdchg_haserror}}
                <div class="error">
                    <ul>
                    {{foreach ~userpswdchg_error}}
                        <li>{{this}}</li>
                    {{endfor ~userpswdchg_error}}
                    </ul>
                </div>
            {{endif ~userpswdchg_haserror}}
        </div>
        <div>
            <label for="usertipo">Tipo de Usuario</label>
            <input type="text" name="usertipo" id="usertipo" value="{{usertipo}}" {{~readonly}}>
            {{if ~usertipo_haserror}}
                <div class="error">
                    <ul>
                    {{foreach ~usertipo_error}}
                        <li>{{this}}</li>
                    {{endfor ~usertipo_error}}
                    </ul>
                </div>
            {{endif ~usertipo_haserror}}
        </div>
        <div>
            {{if ~showConfirm}}
            <button type="submit">Confirmar</button>&nbsp;
            {{endif ~showConfirm}}
            <button id="btnCancelar" class="btn">Cancelar</button>
        </div>
        {{if ~global_haserror}}
            <div class="error">
                <ul>
                    {{foreach ~global_error}}
                        <li>{{this}}</li>
                    {{endfor ~global_error}}
                </ul>
            </div>
        {{endif ~global_haserror}}
        {{endwith usuario}}
    </form>
</section>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const btnCancelar = document.getElementById("btnCancelar");
        btnCancelar.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=Usuarios-UsuariosList");
        });
    });
</script>
