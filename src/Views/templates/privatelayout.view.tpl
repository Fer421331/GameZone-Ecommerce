<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{SITE_TITLE}}</title>

  <link rel="icon" type="image/jpeg" href="{{BASE_DIR}}/public/imgs/hero/logo.jpg">

  <link rel="preconnect" href="https://fonts.gstatic.com">

  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Manrope:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="{{BASE_DIR}}/public/css/gamezone.css">

  <script src="https://kit.fontawesome.com/{{FONT_AWESOME_KIT}}.js" crossorigin="anonymous"></script>

  {{foreach SiteLinks}}
  <link rel="stylesheet" href="{{~BASE_DIR}}/{{this}}">
  {{endfor SiteLinks}}

  {{foreach BeginScripts}}
  <script src="{{~BASE_DIR}}/{{this}}"></script>
  {{endfor BeginScripts}}

</head>

<body class="app-shell private-shell">

  <header class="site-header">


    <div class="brand-lockup">
      <h1>🎮 GameZone</h1>
      <p class="brand-caption">Panel Administrativo</p>
    </div>

    <nav id="menu" class="site-nav">

      <ul class="site-nav-list">

        <li>
          <a href="index.php?page={{PRIVATE_DEFAULT_CONTROLLER}}">
            <i class="fas fa-home"></i>
            &nbsp;Inicio
          </a>
        </li>

        {{foreach NAVIGATION}}

        <li>
          <a href="{{nav_url}}">
            {{nav_label}}
          </a>
        </li>

        {{endfor NAVIGATION}}

        <li>
          <a href="index.php?page=sec_logout">
            <i class="fas fa-sign-out-alt"></i>
            &nbsp;Salir
          </a>
        </li>

      </ul>

    </nav>

    {{with login}}

    <div class="username">

      <i class="fas fa-user-circle"></i>

      <span>{{userName}}</span>

    </div>

    {{endwith login}}

  </header>

  <main class="site-main">

    <div class="page-shell">

      {{{page_content}}}

    </div>

  </main>

  <footer class="site-footer">

    <div class="page-shell footer-shell">

      © {{~CURRENT_YEAR}} GameZone | Todos los Derechos Reservados

    </div>

  </footer>

  {{foreach EndScripts}}

  <script src="{{~BASE_DIR}}/{{this}}"></script>

  {{endfor EndScripts}}

</body>

</html>