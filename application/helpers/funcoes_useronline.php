<?php

function getTime(){
    date_default_timezone_set('America/Sao_Paulo');
    return time() + (60 * 10);
}


function verifica_ip_online($con){
    $ip = getIp();

    $sql = $con->prepare("SELECT * FROM usuarios_online WHERE ip = ?");
    $sql->bind_param("s", $ip);
    $sql->execute();

    return $sql->get_result()->num_rows;
}


function deleta_linhas($con){
    $tempo = getTime() - (60 * 20);
    $sql = $con->prepare("DELETE FROM usuarios_online WHERE tempo < ?");
    $sql->bind_param("s", $tempo);
    $sql->execute();

}


function grava_ip_online($con){
    deleta_linhas($con);

    $ip = getIp();
    $tempo = getTime();

    if(verifica_ip_online($con) <= 0){
        if(!$_SESSION['userLogin']){
            $sql = $con->prepare("INSERT INTO usuarios_online (tempo, ip) VALUES (?, ?)");
            $sql->bind_param("ss", $tempo, $ip);
            $sql->execute();
        }else if($_SESSION['userLogin']){
            $query = $con->prepare("INSERT INTO usuarios_online (tempo, ip, sessao) VALUES (?, ?, ?)");
            $query->bind_param("sss", $tempo, $ip, $_SESSION['userLogin']);
            $query->execute();
        }
    }else{
        if(!$_SESSION['userLogin']){
            $sql = $con->prepare("UPDATE usuarios_online SET tempo = ?, ip = ? WHERE ip = ?");
            $sql->bind_param("sss", $tempo, $ip, $ip);
            $sql->execute();
        }else if($_SESSION['userLogin']){
            $sql = $con->prepare("UPDATE usuarios_online SET tempo = ?, ip = ?, sessao = ? WHERE ip = ?");
            $sql->bind_param("ssss", $tempo, $ip, $_SESSION['userLogin'], $ip);
            $sql->execute();
        }

    }
}


function pega_totalUsuariosOnline($con){
    $sql = $con->prepare("SELECT * FROM usuarios_online WHERE sessao IS NOT NULL");
    $sql->execute();x
    return $sql->get_result()->num_rows;
}


function pega_totalVisitantesOnline($con){
$sql = $con->prepare("SELECT * FROM usuarios_online WHERE sessao IS NULL");
$sql->execute();
return $sql->get_result()->num_rows;
}


echo grava_ip_online($con);

echo "<br>Total usuários online: ".pega_totalUsuariosOnline($con);
echo "<br>Total Visitantes online: ".pega_totalVisitantesOnline($con);
