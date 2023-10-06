<?php
 include('config.php');
$cnn = conectar();
if (isset($_GET['tipo'])) {
    switch ($_GET['tipo']) {
        case 'region':
            $cnn = conectar();
            $query="SELECT id,nombre FROM region ORDER BY nombre";
            $result = $cnn->query($query);
            echo '<option value="0">Seleccionar Region</option>';
            while($r = $result->fetch_object()){
                echo '<option value="'.$r->id.'">'.$r->nombre.'</option>';
            }
        case 'comuna':
            $id_region = $_GET['valor'];
            $sqld = "SELECT comuna.id as id, comuna.nombre as nombre
            FROM comuna
            INNER JOIN region ON comuna.id_region = region.id 
             where region.id = $id_region";
            $rsd = $cnn->query($sqld);
            echo '<option value="0">Seleccionar Comuna</option>';
            while($c = $rsd->fetch_object()){
                echo '<option value="'.$c->id.'">'.$c->nombre.'</option>';
            }
        case 'candidato':
            $queryC="SELECT rut,nombre,apellido FROM candidato ORDER BY nombre";
            $resultC = $cnn->query($queryC);
            echo '<option value="0">Seleccionar Candidato</option>';
            while($c = $resultC->fetch_object()){
                echo '<option value="'.$c->rut.'">'.$c->nombre.' '.$c->apellido.'</option>';
            }
        case 'voto':
            $rut = $_GET['rut'];
            $total = 0;            
            $queryV="SELECT count(*) as total FROM votos where rut='".$rut."'";
            $resultV = $cnn->query($queryV);
            while($v = $resultV->fetch_object()){
                if ($v->total >= 1) {
                    $total= 1;
                
                }
            }
            echo $total;
            
        break;
}
}elseif ($_POST) {
    $como="";
    if(isset($_POST["web"])) $como="web";
    if(isset($_POST["tv"])) $como.=(empty($como))?"tv":", tv";
    if(isset($_POST["redes"])) $como.=(empty($como))?"Redes Sociales":", Redes Sociales";
    if(isset($_POST["amigos"])) $como.=(empty($como))?"Amigos":", Amigos";
    $queryC="INSERT INTO `votos` (nombre,alias,rut,email,id_comuna,id_candidato,como,created_at,updated_at) VALUES ('".$_POST['nombre']."', '".$_POST['alias']."', '".$_POST['rut']."', '".$_POST['email']."', ".$_POST['comuna'].", ".$_POST['candidato'].", '".$como."',NOW(),NOW())";
    if (!$cnn->query($queryC)) {
        echo "Falló la carga de datos: (" . $cnn->errno . ") " . $cnn->error; die;
    }
    header("Location: http://localhost:90/prueba_desis/");
}            

?>