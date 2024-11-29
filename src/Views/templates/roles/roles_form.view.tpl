<link rel="stylesheet" href="public/css/styles.css">
<h1>{{modes_dsc}}</h1>
<section>
    <form action="index.php?page=Roles-RolesForm&mode={{mode}}&rolescod={{rolescod}}" method="post">
        {{with rol}}
        <div>
            <label for="rolescod">Código</label>
            <input type="text" name="rolescod" id="rolescod" value="{{rolescod}}" readonly>
            <input type="hidden" name="xssToken" value="{{~xssToken}}">
        </div>
        <div>
            <label for="rolesdsc">Descripción</label>
            <input type="text" name="rolesdsc" id="rolesdsc" value="{{rolesdsc}}" {{~readonly}}>
            {{if ~rolesdsc_haserror}}
                <div class="error">
                    <ul>
                    {{foreach ~rolesdsc_error}}
                        <li>{{this}}</li>
                    {{endfor ~rolesdsc_error}}
                    </ul>
                </div>
            {{endif ~rolesdsc_haserror}}
        </div>
        <div>
            <label for="rolesest">Estado</label>
            <input type="text" name="rolesest" id="rolesest" value="{{rolesest}}" {{~readonly}}>
            {{if ~rolesest_haserror}}
                <div class="error">
                    <ul>
                    {{foreach ~rolesest_error}}
                        <li>{{this}}</li>
                    {{endfor ~rolesest_error}}
                    </ul>
                </div>
            {{endif ~rolesest_haserror}}
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
        {{endwith rol}}
    </form>
</section>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const btnCancelar = document.getElementById("btnCancelar");
        btnCancelar.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=Roles-RolesList");
        });
    });
</script>
