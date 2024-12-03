<section>
  <h1>{{FormTitle}}</h1>
</section>
<section>
  {{with usuario}}
  <form action="index.php?page=Users_User&mode={{~mode}}&usercod={{usercod}}" method="POST">
    <div class="form-group">
      <label for="usercodD">Código</label>
      <input readonly disabled type="text" name="usercodD" id="usercodD" placeholder="Código" value="{{usercod}}" />
      <input type="hidden" name="mode" value="{{~mode}}" />
      <input type="hidden" name="usercod" value="{{usercod}}" />
      <input type="hidden" name="token" value="{{~user_xss_token}}" />
    </div>
    <div class="form-group">
      <label for="useremail">Correo Electrónico</label>
      <input type="text" name="useremail" id="useremail" placeholder="Correo Electrónico" value="{{useremail}}" {{~readonly}} />
      {{if useremail_error}}
      <div class="error">
        {{useremail_error}}
      </div>
      {{endif useremail_error}}
    </div>
    <div class="form-group">
      <label for="username">Nombre de Usuario</label>
      <input type="text" name="username" id="username" placeholder="Nombre de Usuario" value="{{username}}" {{~readonly}} />
      {{if username_error}}
      <div class="error">
        {{username_error}}
      </div>
      {{endif username_error}}
    </div>
    <div class="form-group">
      <label for="userpswd">Contraseña</label>
      <input type="password" name="userpswd" id="userpswd" placeholder="Contraseña" value="{{userpswd}}" {{~readonly}} />
      {{if userpswd_error}}
      <div class="error">
        {{userpswd_error}}
      </div>
      {{endif userpswd_error}}
    </div>
    <div class="form-group">
      <label for="userfching">Fecha de Ingreso</label>
      <input type="datetime-local" name="userfching" id="userfching" placeholder="Fecha de Ingreso" value="{{userfching}}" {{~readonly}} />
    </div>
    <div class="form-group">
      <label for="userest">Estado</label>
      <select name="userest" id="userest" {{if ~readonly}} disabled {{endif ~readonly}}>
        <option value="ACT" {{userest_act}}>Activo</option>
        <option value="INA" {{userest_ina}}>Inactivo</option>
      </select>
    </div>
    <div class="form-group">
      <label for="usertipo">Tipo de Usuario</label>
      <select name="usertipo" id="usertipo" {{if ~readonly}} disabled {{endif ~readonly}}>
        <option value="CLI" {{usertipo_cli}}>Cliente</option>
        <option value="ADM" {{usertipo_con}}>Administrador</option>
      </select>
    </div>
    {{endwith usuario}}
    <div class="button-group">
      {{if showCommitBtn}}
      <button class="btn primary" type="submit" name="btnConfirmar">Confirmar</button>
      {{endif showCommitBtn}}
      <button class="btn secondary" type="button" id="btnCancelar">
        {{if showCommitBtn}}Cancelar{{endif showCommitBtn}}
        {{ifnot showCommitBtn}}Regresar{{endifnot showCommitBtn}}
      </button>
    </div>
  </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const btnCancelar = document.getElementById("btnCancelar");
    btnCancelar.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      window.location.assign("index.php?page=Users_Users");
    });
  });
</script>

<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
    line-height: 1.6;
  }

  section {
    margin: 2rem auto;
    max-width: 600px;
    padding: 2rem;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    border-left: 8px solid #f39c12;
  }

  h1 {
    text-align: center;
    font-size: 2.5rem;
    color: #e74c3c;
    margin-bottom: 1.5rem;
    font-weight: 700;
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  label {
    display: block;
    font-weight: bold;
    margin-bottom: 0.5rem;
    color: #555;
  }

  input, select {
    width: 100%;
    padding: 0.75rem;
    font-size: 1rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    transition: all 0.3s ease;
    background-color: #fafafa;
  }

  input:focus, select:focus {
    border-color: #e74c3c;
    outline: none;
    box-shadow: 0 0 8px rgba(231, 76, 60, 0.4);
  }

  input:disabled {
    background-color: #f0f0f0;
  }

  .button-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .btn {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .btn.primary {
    background-color: #e74c3c;
    color: #ffffff;
  }

  .btn.primary:hover {
    background-color: #c0392b;
  }

  .btn.secondary {
    background-color: #f39c12;
    color: #ffffff;
  }

  .btn.secondary:hover {
    background-color: #e67e22;
  }

  .error {
    color: #e74c3c;
    font-size: 0.875rem;
    margin-top: 0.25rem;
  }
</style>