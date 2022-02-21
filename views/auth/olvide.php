<div class="contenedor olvide">
  <?php include_once __DIR__.'/../templates/nombre-sitio.php'; ?>

  <div class="contenedor-sm">
    <p class="descripcion-pagina">Recupera tu acceso UpTask</p>

    <form action="/olvide" method="POST" class="formulario">
      <div class="campo">
        <label for="email">Email</label>
        <input 
          type="email" 
          name="email" 
          id="email"
          placeholder="Tu Email"
        />
      </div>

      <input type="submit" class="boton" value="Cambiar Contraseña">
    </form>

    <div class="acciones">
      <a href="/crear">¿Aún no tienes una cuenta? Crea una.</a>
      <a href="/">¿Ya tienes cuenta? Inicia Sesión</a>
    </div>
  </div><!--.contenedor-sm-->
</div>