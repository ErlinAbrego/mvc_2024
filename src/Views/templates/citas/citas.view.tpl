<link rel="stylesheet" href="public/css/cards.css">
<h1>Listado de Citas</h1>
<style>
    .buscar-form {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
        background-color: #f3f3f3;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .buscar-form div {
        display: flex;
        align-items: center;
    }

    .buscar-form label {
        margin-right: 10px;
        font-weight: bold;
        color: #333;
    }

    .buscar-form input[type="text"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
        transition: all 0.3s ease;
    }

    .buscar-form input[type="text"]:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .buscar-form button {
        background-color: #007bff;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        margin-left: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .buscar-form button:hover {
        background-color: #0056b3;
    }

    .buscar-form button i {
        margin-left: 5px;
    }
</style>

<form method="get" action="index.php" class="buscar-form">
    <input type="hidden" name="page" value="Citas-CitasList">
    <div>
        <label for="usercod">Buscar por Código de Usuario:</label>
        <input type="text" name="usercod" id="usercod" value="{{usercod}}">
        <button type="submit">Buscar <i class="fas fa-search"></i></button>
    </div>
</form>
<section class="wwerl">



    <table>
        <thead>
            <tr>
                <th>Código de la Cita</th>
                <th>Código de Usuario</th>
                <th>Fecha de la Cita</th>
                <th>Tipo de Examen</th>
                <th>Estado de la Cita</th>

                {{if FechaCreacion_enable}}
                <td>{{citas_FechaCreacion}}</td>
                {{endif FechaCreacion_enable}}

                <th>Fecha de Modificación</th>
                <th><a href="index.php?page=Citas-CitasForm&mode=INS"><i class="fa-solid fa-suitcase-medical"
                            style="color: #fff;"></i></a></th>
            </tr>
        </thead>
        <tbody>
            {{foreach citas}}
            <tr>
                <td>{{CitaID}}</td>
                <td>{{usercod}}</td>
                <td>{{FechaCita}}</td>
                <td>{{TipoExamen}}</td>
                <td>{{EstadoCita}}</td> <!-- EstadoCita actualizado -->

                {{if ~FechaCreacion_enable}}
                <td>{{citas_FechaCreacion}}</td>
                {{endif ~FechaCreacion_enable}}

                <td>{{FechaModificacion}}</td>
                <td style="display:flex; gap:1rem; justify-content:center; align-items:center">

                    {{if ~UPD_enable}}
                    <a href="index.php?page=Citas-CitasForm&mode=UPD&CitaID={{CitaID}}"><i class="fas fa-user-pen"
                            style="color: #16a34a;"></i></a>
                    {{endif ~UPD_enable}}
                    {{if ~DEL_enable}}
                    <a href="index.php?page=Citas-CitasForm&mode=DEL&CitaID={{CitaID}}"><i class="fas fa-trash-can"
                            style="color: #16a34a;"></i></a>
                    {{endif ~DEL_enable}}
                    <a href="index.php?page=Citas-CitasForm&mode=DSP&CitaID={{CitaID}}"><i class="fas fa-search"
                            style="color: #16a34a;"></i></a>
                </td>
            </tr>
            {{endfor citas}}
        </tbody>
    </table>
</section>