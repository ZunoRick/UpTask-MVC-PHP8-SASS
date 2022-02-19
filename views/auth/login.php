<div class="contenedor login">
  <h1 class="uptask">UpTask</h1>
  <p class="tagline">Crea y Administra tus Proyectos</p>

  <div class="contenedor-sm">
    <p class="descripcion-pagina">Iniciar Sesión</p>

    <form action="/" method="POST" class="formulario">
      <div class="campo">
        <label for="email">Email</label>
        <input 
          type="email" 
          name="email" 
          id="email"
          placeholder="Tu Email"
        />
      </div>

      <div class="campo">
        <label for="password">Password</label>
        <input 
          type="password" 
          name="password" 
          id="password"
          placeholder="Tu Password"
        />
      </div>

      <input type="submit" class="boton" value="Iniciar Sesión">
    </form>

    <div class="acciones">
      <a href="/crear">¿Aún no tienes una cuenta? Crea una.</a>
      <a href="/olvide">¿Olvidaste tu Password?</a>
    </div>
  </div><!--.contenedor-sm-->
</div>