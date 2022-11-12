<?php 
/*
 * OLIFX - Feliz-RS                |  https://github.com/OLIFX
 * by: Otávio Maldaner             |  https://github.com/OtavioMaldaner
 *     Luis Felipe Assmann         |  https://github.com/luisdef
 *     Matheus Persch              |  https://github.com/DevTheusP 
 *
 * 2022.11.12 - Bom Princípio - RS
 * ♪ Um Pedido - Acústico | Hungria Hip Hop
 *
 * Descrição sobre a funcionalidade do arquivo
 * 
 */
require_once __DIR__.'/_local/config.php';
// if(log_operacoes) $microtimeStart = microtime(true);
$status = 500;
try
{
    // Código aqui
}
catch(Exception $e)
{
    $status = 506; // Internal Error/Conflict
    // internalLOG(6, 'Exception in \''.__FILE__.'\' e=\''.$e->__toString().'\'.');
}
// if(log_operacoes)
// {
//     $microtimeTotal = microtime(true) - $microtimeStart;
//     internalLOG(11, "[$microtimeTotal s] ".__FILE__."( ".json_encode($_POST)." ) -> status='".$status."'");
// }

if(isset($result)){
    echo json_encode($result);
}

http_response_code($status);

?>