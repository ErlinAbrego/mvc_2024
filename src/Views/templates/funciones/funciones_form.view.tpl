<link rel="stylesheet" href="public/css/styles.css">
<h1>{{modes_dsc}}</h1>
<section>
    <form action="index.php?page=Funciones-FuncionesForm&mode={{mode}}&fncod={{fncod}}" method="post">
        {{with funcion}}
        <div>
            <label for="fncod">Código</label>
            <input type="text" name="fncod" id="fncod" value="{{fncod}}" readonly>
            <input type="hidden" name="xssToken" value="{{~xssToken}}">
        </div>
        <div>
            <label for="fndsc">Descripción</label>
            <input type="text" name="fndsc" id="fndsc" value="{{fndsc}}" {{~readonly}}>
            {{if ~fndsc_haserror}}
            <div class="error">
                <ul>
                    {{foreach ~fndsc_error}}
                    <li>{{this}}</li>
                    {{endfor ~fndsc_error}}
                </ul>
            </div>
            {{endif ~fndsc_haserror}}
        </div>
        <div>
            <label for="fnest">Estado</label>
            <input type="text" name="fnest" id="fnest" value="{{fnest}}" {{~readonly}}>
            {{if ~fnest_haserror}}
            <div class="error">
                <ul>
                    {{foreach ~fnest_error}}
                    <li>{{this}}</li>
                    {{endfor ~fnest_error}}
                </ul>
            </div>
            {{endif ~fnest_haserror}}
        </div>
        <div>
            <label for="fntyp">Tipo</label>
            <input type="text" name="fntyp" id="fntyp" value="{{fntyp}}" {{~readonly}}>
            {{if ~fntyp_haserror}}
            <div class="error">
                <ul>
                    {{foreach ~fntyp_error}}
                    <li>{{this}}</li>
                    {{endfor ~fntyp_error}}
                </ul>
            </div>
            {{endif ~fntyp_haserror}}
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
        {{endwith funcion}}
    </form>
</section>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const btnCancelar = document.getElementById("btnCancelar");
        btnCancelar.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=Funciones-FuncionesList");
        });
    });
</script>