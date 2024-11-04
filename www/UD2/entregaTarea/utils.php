<?php

$tareas = [    
    ["id" => "diw01", "descripcion" => "Accesibilidad Web", "estado" => "completada"],
    ["id" => "diw02", "descripcion" => "Usabilidad Web", "estado" => "proceso"],
    ["id" => "daw01", "descripcion" => "Servidores Web", "estado" => "compleado"],
    ["id" => "dwcc01", "descripcion" => "Objetos nativos de Javascript", "estado" => "pendiente"],
    ["id" => "dwcs01", "descripcion" => "Lista de tareas", "estado" => "proceso"]
];


function devolver_lista_tareas($tareas) {
    foreach ($tareas as $tarea) {
        echo "<tr>";
            echo "<td>".$tarea['id']."</td>";
            echo "<td>".$tarea['descripcion']."</td>";
            echo "<td>".$tarea['estado']."</td>";
        echo "</tr>";
    }
}

function filtrar_campos($campo) {
    $campo = trim($campo);
    $campo = stripslashes($campo);
    $campo = htmlspecialchars($campo);
    return $campo;
}

function validacion_campos($campo) {
    if (!empty($campo) && strlen($campo) >= 3 && strlen($campo) <= 30) {
        return true;
    } else {
        return false;
    }
}

function guardar_tareas($id, $descripcion, $estado){

    $id_filtrado = filtrar_campos($id);
    $descripcion_filtrado = filtrar_campos($descripcion);
    $estado_filtrado = filtrar_campos($estado);
    
    if(validacion_campos($id_filtrado) && validacion_campos($descripcion_filtrado) && validacion_campos($estado_filtrado)){
        global $tareas;
        $tarea = ["id" => $id_filtrado, "descripcion" => $descripcion_filtrado, "estado" => $estado_filtrado];
        $tareas[] = $tarea;
        return true;
    } else {
        return false;
    }
}
?>