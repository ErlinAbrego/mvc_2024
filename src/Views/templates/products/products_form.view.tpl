<link rel="stylesheet" href="public/css/styles.css">
<h1>{{modes_dsc}}</h1>
<section>
    <form action="index.php?page=Products-ProductsForm&mode={{mode}}&productId={{productId}}" method="post">
        {{with productos}}
        <div>
            <label for="productId">Código</label>
            <input type="text" name="productId" id="productId" value="{{productId}}" readonly>
        </div>
        <div>
            <label for="productName">Nombre</label>
            <input type="text" name="productName" id="productName" value="{{productName}}" {{~readonly}}>
        </div>
        <div>
            <label for="productDescription">Descripción</label>
            <input type="text" name="productDescription" id="productDescription" value="{{productDescription}}"
                {{~readonly}}>
        </div>
        <div>
            <label for="productPrice">Precio</label>
            <input type="text" name="productPrice" id="productPrice" value="{{productPrice}}" {{~readonly}}>
        </div>
        <div>
            <label for="productImgUrl">Imagen</label>
            <input type="text" name="productImgUrl" id="productImgUrl" value="{{productImgUrl}}" {{~readonly}}>
        </div>
        <div>
            <label for="productStock">Inventario</label>
            <input type="text" name="productStock" id="productStock" value="{{productStock}}" {{~readonly}}>
        </div>
        <div>
            <label for="productStatus">Estado</label>
            <input type="text" name="productStatus" id="productStatus" value="{{productStatus}}" {{~readonly}}>
        </div>
        <div>
            {{if ~showConfirm}}
            <button type="submit">Confirmar</button>&nbsp;
            {{endif ~showConfirm}}
            <button id="btnCancelar" class="btn">Cancelar</button>
        </div>
        {{endwith productos}}
    </form>
</section>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const btnCancelar = document.getElementById("btnCancelar");
        btnCancelar.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=Products-ProductsList");
        });
    });
</script>