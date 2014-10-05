<?php
$action = $_GET['action'];
$idCat  = $_GET['idCat'];
$idSub  = $_GET['idSub'];
$editar = $_GET['editar'];
?>



<select name="subcateg" id="subcateg" <?php if(($action!='selected')||($idCat=='null')){echo"disabled='true'";}?> >
    <?php
    include('../../classes/config.php');                                
    include('../classes/subCategoria.php');
    
    $config = new config();
    $subCat = new subCategoria();
    
    $subcategorias = $subCat->getTitulosSubCategorias(false, $idCat);

    $end = "";
    $x   = 0;

    while( $end != "end" )
    {
        if( $subcategorias[$x] == "end" ) // Se acabou todas as categorias, termina o loop.
        {
            break;
        }
        
        if( ($editar == 'true') && ($subcategorias[$x] == $idSub) )
        {
            echo "<option value='".$subcategorias[$x]."' selected>".$subcategorias[$x+1]."</option>";
        }
        else if( ($subcategorias[$x] == 'null') && ($editar != 'true') ) // Se a subcategoria é vasia, deixá-la selecionada
        {
            echo "<option value='".$subcategorias[$x]."' selected>".$subcategorias[$x+1]."</option>";
        }
        else if( ($subcategorias[$x] == 'null') && ( $idSub == 0 ) )
        {
            echo "<option value='".$subcategorias[$x]."' selected>".$subcategorias[$x+1]."</option>";                                        
        }
        else // Imprime os titulos das categorias.
        {                                                               
            echo "<option value='".$subcategorias[$x]."'>".$subcategorias[$x+1]."</option>";                                        
        }

        $end = $subcategorias[$x];
        $x = $x + 2;
    }
    ?>
</select>