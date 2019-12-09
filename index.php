<?php
/*
 *
 * @revision  21
 */


require_once('config.php');


?>
<html lang="en">
<head>
<!--    <title><?php echo $_SERVER['SERVER_NAME']; ?></title>  -->
    <title><?php echo $_SERVER['SERVER_NAME']; ?></title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <style type="text/css">
        <!--
        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }

        A:link {
            FONT-SIZE: 11px;
            COLOR: #0033CC;
            font-family: "Courier New", Courier, monospace;
            TEXT-DECORATION: none;
        }

        A:visited {
            FONT-SIZE: 11px;
            COLOR: #0033CC;
            font-family: "Courier New", Courier, monospace;
            TEXT-DECORATION: none;
        }

        A:active {
            FONT-SIZE: 11px;
            COLOR: #0033CC;
            font-family: "Courier New", Courier, monospace;
            TEXT-DECORATION: none;
        }

        A:hover {
            FONT-SIZE: 11px;
            COLOR: #FF0000;
            font-family: "Courier New", Courier, monospace;
            TEXT-DECORATION: none;
        }

        .comments {
            FONT-SIZE: 11px;
            COLOR: #333333;
            font-family: "Courier New", Courier, monospace;
            TEXT-DECORATION: none;
        }

        .comments_no {
            FONT-SIZE: 11px;
            COLOR: #ffffff;
            font-family: "Courier New", Courier, monospace;
            TEXT-DECORATION: none;
        }

        .columna1 {
            padding-left:6px;
            min-width: 222px;
	    border-right: 1px solid lightgrey;
        }

        .par {
            background-color: #f0f0f0;
        }

        .impar {
            background-color: #ffffff;
        }

        .titulo {
            text-align: right;

        }

        .descripcion {
            text-align: left;
        }

        .info {
            color: #ccc;
            float: right;
            border: 1px solid #efefef;
            padding: 10px;
        }

        #titulo {
            float: right;
            font-weight: bold;
            display: none;
        }
        .cajaeditar {
            border-color: white;
            border:0px;
            FONT-SIZE: 11px;
            COLOR: #333333;
            font-family: "Courier New", Courier, monospace;
            TEXT-DECORATION: none;
            outline: none;
        }

        -->
    </style>
</head>

<body>
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
                        echo $dir . '/' . $file . '<br>';
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
                $cssclass = "imppar";
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
echo '<small class="info">';
echo "date =" . date('Y-m-d--His');
echo "<br>";
echo "repositories = " . $j;
echo "<br>";
echo "dir=$dir";
echo "</small>";

?>


<script src="./node_modules/vue/dist/vue.js"></script>
<script src="./node_modules/axios/dist/axios.js"></script>


<script type="application/javascript">
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

</script>


</body>
</html>
