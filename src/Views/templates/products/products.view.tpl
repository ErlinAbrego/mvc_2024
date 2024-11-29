<link rel="stylesheet" href="public/css/cards.css">
<h1>Catálogo de Productos</h1>
<section class="wwerl">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Estado</th>
                <th><a href="index.php?page=Products-ProductsForm&mode=INS"><i class="fa-solid fa-suitcase-medical" style="color: #fff;"></i></a></th>
            </tr>
        </thead>
        <tbody>
            {{foreach productos}}
                <tr>
                    <td>{{productId}}</td>
                    <td>{{productName}}</td>
                    <td>{{productDescription}}</td>
                    <td>{{productPrice}}</td>
                    <td>{{estado_dsc}}</td>
                    <td style="display:flex; gap:1rem; justify-content:center; align-items:center">
                        <a href="index.php?page=Products-ProductsForm&mode=UPD&productId={{productId}}"><i class="fas fa-edit" style="color: #2e86c1;"></i></a>
                        <a href="index.php?page=Products-ProductsForm&mode=DEL&productId={{productId}}"><i class="fas fa-trash" style="color: #2e86c1;"></i></a>
                        <a href="index.php?page=Products-ProductsForm&mode=DSP&productId={{productId}}"><i class="fas fa-eye" style="color: #2e86c1;"></i></a>
                    </td>
                </tr>
            {{endfor productos}}
        </tbody>
    </table>
</section>
