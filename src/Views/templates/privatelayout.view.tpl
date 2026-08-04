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

  <style>
    .user-dropdown {
      position: relative;
      display: inline-block;
    }

    .user-button {

      display: flex;
      align-items: center;
      gap: 12px;

      background: #21262d;

      color: #fff;

      border: 1px solid rgba(255, 255, 255, .08);

      border-radius: 50px;

      padding: 10px 18px;

      min-width: 150px;

      justify-content: space-between;

      cursor: pointer;

      font-size: 14px;

      font-weight: 700;

      transition: .25s ease;

      box-shadow: 0 5px 20px rgba(0, 0, 0, .25);
    }

    .user-button:hover {

      background: #2d333b;

      border-color: #3b82f6;

      transform: translateY(-2px);
    }

    .user-button i {

      font-size: 17px;
    }

    .user-button .fa-chevron-down {

      font-size: 12px;

      transition: .25s;
    }

    .user-button.active .fa-chevron-down {

      transform: rotate(180deg);
    }



    .dropdown-menu-user {

      position: absolute;

      top: calc(100% + 12px);

      right: 0;

      width: 240px;

      background: #161b22;

      border: 1px solid rgba(255, 255, 255, .08);

      border-radius: 14px;

      overflow: hidden;

      box-shadow:
        0 15px 35px rgba(0, 0, 0, .45);

      display: none;

      z-index: 99999;

      animation: fadeDown .25s;
    }

    .dropdown-menu-user.show {

      display: block;
    }



    .dropdown-menu-user a {

      display: flex;

      align-items: center;

      gap: 14px;

      padding: 16px 20px;

      color: #d1d5db;

      font-size: 15px;

      font-weight: 600;

      transition: .25s;
    }

    .dropdown-menu-user a i {

      width: 20px;

      text-align: center;

      color: #60a5fa;
    }

    .dropdown-menu-user a:hover {

      background: #2563eb;

      color: #fff;

      padding-left: 26px;
    }

    .dropdown-menu-user a:hover i {

      color: #fff;
    }



    .dropdown-divider {

      height: 1px;

      background: #30363d;
    }



    @keyframes fadeDown {

      from {

        opacity: 0;

        transform: translateY(-12px);
      }

      to {

        opacity: 1;

        transform: translateY(0);
      }

    }
  </style>

</head>

<body class="app-shell private-shell">

  <header class="site-header">

    <div class="brand-lockup">

      <h1>🎮 GameZone</h1>

      <p class="brand-caption">{{PANEL_CAPTION}}</p>

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

      </ul>

    </nav>

    {{with login}}

    <div class="user-dropdown">
      <button id="userMenuBtn" class="user-button">

        <i class="fas fa-user-circle"></i>

        <span>{{userName}}</span>

        <i class="fas fa-chevron-down"></i>

      </button>

      <div id="userMenu" class="dropdown-menu-user">

        {{foreach ~userMenu}}

        <a href="{{url}}">

          <i class="{{icon}}"></i>

          {{label}}

        </a>

        {{endfor ~userMenu}}

      </div>

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

  <script>

    document.addEventListener("DOMContentLoaded", function () {

      const btn = document.getElementById("userMenuBtn");
      const menu = document.getElementById("userMenu");

      if (!btn || !menu) {
        return;
      }

      btn.addEventListener("click", function (e) {

        e.stopPropagation();

        menu.classList.toggle("show");

        btn.classList.toggle("active");

      });

      menu.addEventListener("click", function (e) {

        e.stopPropagation();

      });

      document.addEventListener("click", function () {

        menu.classList.remove("show");

        btn.classList.remove("active");

      });

    });

  </script>

</body>

</html>