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
    $campo_validado = filtrar_campos($campo);
    if ($campo_validado !== "") {
        return true;
    } else {
        return false;
    }
}

function guardar_tareas($id, $descripcion, $estado){
    if(validacion_campos($id) && validacion_campos($descripcion) && validacion_campos($estado)){
        global $tareas;
        $tarea = ["id" => $id, "descripcion" => $descripcion, "estado" => $estado];
        $tareas[] = $tarea;
        return true;
    } else {
        return false;
    }
}
?>