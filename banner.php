<link rel="stylesheet" href="css/orbit-1.2.3.css">
<link rel="stylesheet" href="css/corpo.css">
<link rel="stylesheet" href="css/demo-style.css">
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery.orbit-1.2.3.min.js"></script>
<script type="text/javascript" src="js/orbit.js"></script>

<div id='banner' align="center">
    <div id="featured">
        <?php
        $dir = opendir("Imagens/banner/");        

        while ($read = readdir($dir)) 
        {
            if ($read != '.' && $read != '..') 
            {
                echo "<img width='870px' height='250px' src='Imagens/banner/$read' />";
            }
        }
        closedir($dir);
        ?>
    </div>
</div>
