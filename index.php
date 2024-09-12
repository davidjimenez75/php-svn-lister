<?php
/**
 * php-svn-lister
 * 
 * List all repositories in a directory and show a description for each one.
 * 
 * @revision  2024.09.21
 */
require_once('config.php');
?><html lang="en">
<head>
    <title><?php echo $_SERVER['SERVER_NAME']; ?></title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="./light-mode.css">
    <link rel="stylesheet" type="text/css" href="./dark-mode.css">
</head>


<body class="light-mode">
<!-- Icono flotante -->
<nav>
  <button id="mode-toggle" class="mode-button">🌞</button>
</nav>


<?php echo "<div id=\"titulo\">" . $_SERVER['SERVER_NAME'] . "</div>"; ?>

<div id="app">

    <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <?php

        $i = 0;

        $handle = opendir($dir);

        while ($file = readdir($handle)) {
            if ($file != "." && $file != ".." && $file != "index.php" && $file != ".git" && $file != "node_modules") {
                if (is_dir($dir . '/' . $file)) {
                    if ($debug) {
                        echo "DIR=".$dir . '/' . $file . '<br>';
                    }
                    $a_lineas[$i]["file"] = $file;
                    $i++;
                }elseif(is_link($dir . '/' . $file)) {
                    if ($debug) {
                        echo "LINK=".$dir . '/' . $file . '<br>';
                    }
                    $a_lineas[$i]["file"] = $file;
                    $i++;
                }
            }
        }
        closedir($handle);
        sort($a_lineas);

        $j = 0;
        foreach ($a_lineas as $linea => $valor) {
            //$url = 'http://' . $valor["file"].'fakedomain.net';
            //$url = 'http://' . $valor["file"].'.localhost';
            $url = $url_svn.$valor["file"].$url_suffix.'/';
            $file = $valor["file"] . ".txt";
            $description = "";
            if($j%2==0) {
                $cssclass = "par";
            }else{
                $cssclass = "impar";
            }
            if (file_exists($file)) {
                $description = file_get_contents($file);
            }
            $a_files[$file] = array('index' => substr($file,0,-4), 'url' => $url, 'cssclass'=> $cssclass, 'descripcion' => $description);
            $j++;
        }
        ?>

        <tr v-for="(elemento, index) in contenido" :class="elemento.cssclass">
            <td class="columna1"><a :href="elemento.url" class="titulo"><strong>{{ elemento.index }}</strong></a></td>
            <td><input v-model="elemento.descripcion" size=120 @keyup.enter="grabar(index,elemento.descripcion)" class="cajaeditar" :class="elemento.cssclass"></td>
        </tr>

    </table>

</div><!--endtable-->


<?php
echo '<div id="info" class="info">';
echo "date =" . date('Y-m-d--His');
echo "<br>";
echo "repositories = " . $j;
echo "<br>";
echo "dir=$dir";
echo "</div>";

?>


<script src="./node_modules/vue/dist/vue.js"></script>
<script src="./node_modules/axios/dist/axios.js"></script>


<script type="application/javascript">

    // vue.js - Editar descripciones de los repositorios en linea.

    var vm = new Vue({
        el: '#app',
        data: {
            contenido: <?php echo json_encode($a_files, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);?>      ,
            editando: false,
            grabando: false
        },
        mounted: function () {

        },
        methods: {
            grabar: function (fichero, contenido) {
                console.log("grabando: " + fichero + " --> " + contenido)
                axios.patch('api.php?file='+fichero, contenido)
            },
        }
    })


    // TOGGLE LIGHT/DARK MODE

    // Obtener el botón de cambio de estilo
    const modeToggle = document.getElementById('mode-toggle');

    // Definir la función que cambia el estilo
    function toggleMode() {
        const bodyClass = document.body.classList;
        
        // Cambiar entre estilos claros y oscuros
        if (bodyClass.contains('light-mode')) {
            bodyClass.remove('light-mode');
            bodyClass.add('dark-mode');
            document.getElementById('mode-toggle').innerHTML = '🌚';
        } else {
            bodyClass.remove('dark-mode');
            bodyClass.add('light-mode');
            document.getElementById('mode-toggle').innerHTML = '🌞';
        }
    }

    // Agregar el evento de click al botón
    modeToggle.addEventListener('click', toggleMode);




    function detectSystemDarkMode() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    }

    function isNightTime() {
        const hour = new Date().getHours();
        return hour >= 22 || hour < 9;
    }

    if (detectSystemDarkMode() || isNightTime()) {
        toggleMode();
    }





</script>


</body>
</html>
