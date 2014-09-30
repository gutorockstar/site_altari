<link rel="stylesheet" href="css/corpo.css" type="text/css" media="screen" />

<body style="font-family:'Trebuchet MS', Arial;font-size: 13px;">    
    <?php
    $data    = $_GET['data'];
    $titulo  = $_GET['titulo'];
    $noticia = $_GET['noticia'];

    echo "<p style='color:#222;font-size:15px;font-weight:bold;'>$data - $titulo</p>";
    echo "<div align='left' width='300px'>"
            .$noticia.
         "</div>";
    ?>
</body>
