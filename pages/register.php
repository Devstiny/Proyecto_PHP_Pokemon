<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>register</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <!-- CSS LINK -->
    <link rel="stylesheet" href=".././css/style.css" />
    <!-- FONT LINK -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet" />
    <!-- FONTAWESOME -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

      <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    <!-- Header navbar -->
    <header class="bg-dark text-white sticky top-0 z-10">
        <div class="container mx-auto px-4 py-2">
            <div class="flex flex-wrap items-center justify-between">
                <a
                        href="./../index.html"
                        class="flex items-center text-white text-decoration-none space-x-2 hover:text-red-500"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" fill="currentColor" class="bi bi-fan" viewBox="0 0 16 16">
                        <path
                                d="M10 3c0 1.313-.304 2.508-.8 3.4a2 2 0 0 0-1.484-.38c-.28-.982-.91-2.04-1.838-2.969a8 8 0 0 0-.491-.454A6 6 0 0 1 8 2c.691 0 1.355.117 1.973.332Q10 2.661 10 3m0 5q0 .11-.012.217c1.018-.019 2.2-.353 3.331-1.006a8 8 0 0 0 .57-.361 6 6 0 0 0-2.53-3.823 9 9 0 0 1-.145.64c-.34 1.269-.944 2.346-1.656 3.079.277.343.442.78.442 1.254m-.137.728a2 2 0 0 1-1.07 1.109c.525.87 1.405 1.725 2.535 2.377q.3.174.605.317a6 6 0 0 0 2.053-4.111q-.311.11-.641.199c-1.264.339-2.493.356-3.482.11ZM8 10c-.45 0-.866-.149-1.2-.4-.494.89-.796 2.082-.796 3.391q0 .346.027.678A6 6 0 0 0 8 14c.94 0 1.83-.216 2.623-.602a8 8 0 0 1-.497-.458c-.925-.926-1.555-1.981-1.836-2.96Q8.149 10 8 10M6 8q0-.12.014-.239c-1.02.017-2.205.351-3.34 1.007a8 8 0 0 0-.568.359 6 6 0 0 0 2.525 3.839 8 8 0 0 1 .148-.653c.34-1.267.94-2.342 1.65-3.075A2 2 0 0 1 6 8m-3.347-.632c1.267-.34 2.498-.355 3.488-.107.196-.494.583-.89 1.07-1.1-.524-.874-1.406-1.733-2.541-2.388a8 8 0 0 0-.594-.312 6 6 0 0 0-2.06 4.106q.309-.11.637-.199M8 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2"
                        />
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                    </svg>
                    <span class="text-lg font-semibold">RUST</span>
                </a>

                <button
                        class="md:hidden text-white hover:text-red-500 focus:outline-none"
                        aria-label="Toggle navigation"
                        id="navbar-toggle"
                >
                    <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M3 6h14M3 10h14M3 14h14" />
                    </svg>
                </button>

                <nav
                        id="navbar-menu"
                        class="hidden md:flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 items-center"
                >
                    <a href="./../index.html" class="flex flex-col items-center text-white hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                            <path
                                    d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"
                            />
                        </svg>
                        <span>Home</span>
                    </a>
                    <a href="./../index.html" class="flex flex-col items-center text-white hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" fill="currentColor" class="bi bi-newspaper" viewBox="0 0 16 16">
                            <path d="M0 2.5A1.5 1.5 0 0 1 1.5 1h11A1.5 1.5 0 0 1 14 2.5v10.528c0 .3-.05.654-.238.972h.738a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 1 1 0v9a1.5 1.5 0 0 1-1.5 1.5H1.497A1.497 1.497 0 0 1 0 13.5zM12 14c.37 0 .654-.211.853-.441.092-.106.147-.279.147-.531V2.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v11c0 .278.223.5.497.5z"></path>
                            <path d="M2 3h10v2H2zm0 3h4v3H2zm0 4h4v1H2zm0 2h4v1H2zm5-6h2v1H7zm3 0h2v1h-2zM7 8h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2z"></path>
                        </svg>
                        <span>Noticias</span>
                    </a>
                    <a href="./../index.html" class="flex flex-col items-center text-white hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" fill="currentColor" class="bi bi-controller" viewBox="0 0 16 16">
                            <path d="M11.5 6.027a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2.5-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m-6.5-3h1v1h1v1h-1v1h-1v-1h-1v-1h1z"></path>
                            <path d="M3.051 3.26a.5.5 0 0 1 .354-.613l1.932-.518a.5.5 0 0 1 .62.39c.655-.079 1.35-.117 2.043-.117.72 0 1.443.041 2.12.126a.5.5 0 0 1 .622-.399l1.932.518a.5.5 0 0 1 .306.729q.211.136.373.297c.408.408.78 1.05 1.095 1.772.32.733.599 1.591.805 2.466s.34 1.78.364 2.606c.024.816-.059 1.602-.328 2.21a1.42 1.42 0 0 1-1.445.83c-.636-.067-1.115-.394-1.513-.773-.245-.232-.496-.526-.739-.808-.126-.148-.25-.292-.368-.423-.728-.804-1.597-1.527-3.224-1.527s-2.496.723-3.224 1.527c-.119.131-.242.275-.368.423-.243.282-.494.575-.739.808-.398.38-.877.706-1.513.773a1.42 1.42 0 0 1-1.445-.83c-.27-.608-.352-1.395-.329-2.21.024-.826.16-1.73.365-2.606.206-.875.486-1.733.805-2.466.315-.722.687-1.364 1.094-1.772a2.3 2.3 0 0 1 .433-.335l-.028-.079zm2.036.412c-.877.185-1.469.443-1.733.708-.276.276-.587.783-.885 1.465a14 14 0 0 0-.748 2.295 12.4 12.4 0 0 0-.339 2.406c-.022.755.062 1.368.243 1.776a.42.42 0 0 0 .426.24c.327-.034.61-.199.929-.502.212-.202.4-.423.615-.674.133-.156.276-.323.44-.504C4.861 9.969 5.978 9.027 8 9.027s3.139.942 3.965 1.855c.164.181.307.348.44.504.214.251.403.472.615.674.318.303.601.468.929.503a.42.42 0 0 0 .426-.241c.18-.408.265-1.02.243-1.776a12.4 12.4 0 0 0-.339-2.406 14 14 0 0 0-.748-2.295c-.298-.682-.61-1.19-.885-1.465-.264-.265-.856-.523-1.733-.708-.85-.179-1.877-.27-2.913-.27s-2.063.091-2.913.27"></path>
                        </svg>
                        <span>Plataformas</span>
                    </a>
                    <a href="./../index.html" class="flex flex-col items-center text-white hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" fill="currentColor" class="bi bi-server" viewBox="0 0 16 16">
                            <path d="M1.333 2.667C1.333 1.194 4.318 0 8 0s6.667 1.194 6.667 2.667V4c0 1.473-2.985 2.667-6.667 2.667S1.333 5.473 1.333 4z"></path>
                            <path d="M1.333 6.334v3C1.333 10.805 4.318 12 8 12s6.667-1.194 6.667-2.667V6.334a6.5 6.5 0 0 1-1.458.79C11.81 7.684 9.967 8 8 8s-3.809-.317-5.208-.876a6.5 6.5 0 0 1-1.458-.79z"></path>
                            <path d="M14.667 11.668a6.5 6.5 0 0 1-1.458.789c-1.4.56-3.242.876-5.21.876-1.966 0-3.809-.316-5.208-.876a6.5 6.5 0 0 1-1.458-.79v1.666C1.333 14.806 4.318 16 8 16s6.667-1.194 6.667-2.667z"></path>
                        </svg>
                        <span>Servidores</span>
                    </a>
                    <a href="./../index.html" class="flex flex-col items-center text-white hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"></path>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"></path>
                        </svg>
                        <span>Log In</span>
                    </a>
                    <!-- Repeat similar nav items for Noticias, Plataformas, Servidores, Log In -->
                </nav>
            </div>
        </div>
    </header>


    <!-- Main container -->
    <main class="container fluid d-flex flex-column mb-5">
      <!-- Section: Design Block -->
        <section class="text-center text-lg-start py-8">
            <!-- Jumbotron -->
            <div class="container">
                <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-8">
                    <!-- Form Section -->
                    <div class="mb-8 lg:mb-0">
                        <div class="bg-white shadow-lg rounded-lg p-8">
                            <h2 class="text-2xl font-bold mb-6">Registro</h2>
                            <form action=".././index.php" method="post">
                                <!-- Nombre de usuario -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-2" for="nombre">Nombre de usuario</label>
                                    <input type="text" id="nombre" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500" required />
                                </div>

                                <!-- Email -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-2" for="email">Email</label>
                                    <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500" required />
                                </div>

                                <!-- Contraseña -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-2" for="contrasena">Contraseña</label>
                                    <input type="password" id="contrasena" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500" required />
                                </div>

                                <!-- Checkbox: Newsletter -->
                                <div class="flex items-center justify-center mb-4">
                                    <input type="checkbox" id="newsletter" class="mr-2 rounded border-gray-300 focus:ring-red-500" checked />
                                    <label class="text-sm" for="newsletter">Recibir las últimas noticias</label>
                                </div>

                                <!-- Checkbox: Términos y condiciones -->
                                <div class="flex items-center justify-center mb-6">
                                    <input type="checkbox" id="terminos" class="mr-2 rounded border-gray-300 focus:ring-red-500" required />
                                    <label class="text-sm" for="terminos">He leído y acepto los términos y condiciones</label>
                                </div>

                                <!-- Submit button -->
                                <button type="submit" class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 transition">
                                    Registro
                                </button>

                                <!-- Login with social media -->
                                <div class="text-center mt-6">
                                    <p class="text-sm mb-4">O inicie sesión con</p>
                                    <div class="flex justify-center space-x-4">
                                        <button type="button" class="text-red-500 hover:text-red-600">
                                            <i class="fab fa-facebook-f text-xl"></i>
                                        </button>
                                        <button type="button" class="text-red-500 hover:text-red-600">
                                            <i class="fab fa-google text-xl"></i>
                                        </button>
                                        <button type="button" class="text-red-500 hover:text-red-600">
                                            <i class="fab fa-twitter text-xl"></i>
                                        </button>
                                        <button type="button" class="text-red-500 hover:text-red-600">
                                            <i class="fab fa-github text-xl"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Image Section -->
                    <div>
                        <img src="./../assets/images/pokeball_mew.webp" alt="Imagen" class="mew animaMew capturaMew m-auto" id="mew"/>
                        <img src=".././assets/images/Pokemon-Pokeball-PNG-Images.webp" class=" pokeball captura" id="pokeball">
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="text-center text-lg-start bg-gray-900 text-white mt-5">
        <!-- Section: Social media -->
        <section class="flex justify-center lg:justify-between items-center p-4 border-b border-gray-700">
            <!-- Left -->
            <div class="hidden lg:block">
                <span></span>
            </div>
            <!-- Right -->
            <div class="space-x-4">
                <a href="#0" class="text-white text-xl hover:text-gray-400">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#0" class="text-white text-xl hover:text-gray-400">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#0" class="text-white text-xl hover:text-gray-400">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#0" class="text-white text-xl hover:text-gray-400">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#0" class="text-white text-xl hover:text-gray-400">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="#0" class="text-white text-xl hover:text-gray-400">
                    <i class="fab fa-github"></i>
                </a>
            </div>
        </section>
        <!-- Section: Social media -->

        <!-- Section: Links -->
        <section>
            <div class="container mx-auto px-6 text-center md:text-left mt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-6">
                    <!-- About -->
                    <div>
                        <h6 class="text-lg font-bold uppercase mb-4 flex items-center">
                            <i class="bi bi-x-circle mr-2"></i> FACEPUNCH
                        </h6>
                        <p>
                            Somos Facepunch, una desarrolladora independiente de juegos autoeditados con sede en Birmingham, Reino Unido. Creamos Garry's Mod y Rust, dos de los juegos de Steam más populares de todos los tiempos.
                        </p>
                    </div>
                    <!-- Help -->
                    <div>
                        <h6 class="text-lg font-bold uppercase mb-4">Ayuda</h6>
                        <ul class="space-y-2">
                            <li>
                                <a href="#0" class="text-gray-400 hover:text-gray-200">Obtener ayuda</a>
                            </li>
                            <li>
                                <a href="#0" class="text-gray-400 hover:text-gray-200">Opciones de pago</a>
                            </li>
                            <li>
                                <a href="#0" class="text-gray-400 hover:text-gray-200">Devoluciones</a>
                            </li>
                            <li>
                                <a href="#0" class="text-gray-400 hover:text-gray-200">Evaluaciones</a>
                            </li>
                        </ul>
                    </div>
                    <!-- Legal -->
                    <div>
                        <h6 class="text-lg font-bold uppercase mb-4">Legal</h6>
                        <ul class="space-y-2">
                            <li>
                                <a href="#0" class="text-gray-400 hover:text-gray-200">Términos de uso</a>
                            </li>
                            <li>
                                <a href="#0" class="text-gray-400 hover:text-gray-200">Aviso legal</a>
                            </li>
                            <li>
                                <a href="#0" class="text-gray-400 hover:text-gray-200">Política de privacidad y cookies</a>
                            </li>
                            <li>
                                <a href="#0" class="text-gray-400 hover:text-gray-200">Acerca de Facepunch</a>
                            </li>
                        </ul>
                    </div>
                    <!-- Contact -->
                    <div>
                        <h6 class="text-lg font-bold uppercase mb-4">Contacto</h6>
                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-home mr-3"></i> 8th Floor, 103 Colmore Row, Birmingham B3 3AG, Reino Unido
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-envelope mr-3"></i> contacto@facepunch.com
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-phone mr-3"></i> +44 234 567 88
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-print mr-3"></i> +44 234 567 89
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section: Links -->

        <!-- Copyright -->
        <div class="text-center p-4 bg-gray-800">
            © 2024 Copyright:
            <a class="text-white font-bold hover:text-gray-400" href="https://riberadeltajo.es/nuevaweb/">Ribera del Tajo</a>
        </div>
        <!-- Copyright -->
    </footer>

    <!-- Footer -->

  </body>
</html>
