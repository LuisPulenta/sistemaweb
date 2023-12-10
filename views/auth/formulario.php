<div class="formulario__campo">
            <label for="nombre">Nombre</label>
            <input class="formulario__input" type="text" id="nombre" placeholder="Ingrese Nombre..." name="nombre" value="<?php echo s($usuario->nombre)?>">
        </div>
        <div class="formulario__campo">
            <label for="apellido">ApellidoS</label>
            <input class="formulario__input" type="text" id="apellido" placeholder="Ingrese Apellido..." name="apellido" value="<?php echo s($usuario->apellido)?>">
        </div>
        <div class="formulario__campo">
            <label for="telefono">Teléfono</label>
            <input class="formulario__input" type="tel" id="apellido" placeholder="Ingrese Teléfono..." name="telefono" value="<?php echo s($usuario->telefono)?>">
        </div>
        <div class="formulario__campo">
            <label for="email">Email</label>
            <input class="formulario__input" type="email" id="email" placeholder="Ingrese Email..." name="email"  value="<?php echo s($usuario->email)?>">
        </div>


        <div class="formulario__campo">
        <label for="imagen" class="formulario__label">Imagen</label>
        <input
            type="file"
            class="formulario__input formulario__input--file"
            id="imagen"
            name="imagen"
        >
    </div>




        <div class="formulario__campo">
            <label for="password">Password</label>
            <input class="formulario__input" type="password" id="password" placeholder="Ingrese Password..." name="password">
        </div>
        <div class="formulario__campo">
                <label for="password2">Repetir Password</label>
                <input class="formulario__input" type="password" id="password" placeholder="Repite tu Password..." name="password2" >
        </div>
        <input type="submit" class="boton" value="Crear Cuenta">