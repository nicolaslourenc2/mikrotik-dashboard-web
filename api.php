<?php
header('Content-Type: application/json');
require_once('config.php');
require_once('routeros_api.class.php');

$API = new RouterosAPI();

if ($API->connect(MK_HOST, MK_USER, MK_PASS, MK_PORT)) {
    // 1. Recursos gerais
    $resourceData = $API->comm('/system/resource/print');
    // 2. Nome do roteador
    $identityData = $API->comm('/system/identity/print');
    // 3. Status das Interfaces de Rede
    $interfaceData = $API->comm('/interface/print');
    
    $API->disconnect();

    $resource = $resourceData[0] ?? [];
    $identity = $identityData[0]['name'] ?? 'Mikrotik';

    // Cálculos de Memória RAM
    $totalMemory = isset($resource['total-memory']) ? round($resource['total-memory'] / 1024 / 1024, 1) : 0;
    $freeMemory  = isset($resource['free-memory'])  ? round($resource['free-memory'] / 1024 / 1024, 1) : 0;
    $usedMemory  = $totalMemory - $freeMemory;
    $memPercent  = $totalMemory > 0 ? round(($usedMemory / $totalMemory) * 100) : 0;

    // Cálculos de HD / Armazenamento Flash
    $totalHdd = isset($resource['total-hdd-space']) ? round($resource['total-hdd-space'] / 1024 / 1024, 1) : 0;
    $freeHdd  = isset($resource['free-hdd-space'])  ? round($resource['free-hdd-space'] / 1024 / 1024, 1) : 0;
    $usedHdd  = $totalHdd - $freeHdd;
    $hddPercent = $totalHdd > 0 ? round(($usedHdd / $totalHdd) * 100) : 0;

    // Contagem de Interfaces Ativas
    $activeInterfaces = 0;
    foreach ($interfaceData as $iface) {
        if (isset($iface['running']) && $iface['running'] == 'true') {
            $activeInterfaces++;
        }
    }

    echo json_encode([
        'success'           => true,
        'identity'          => $identity,
        'cpu_load'          => (int)($resource['cpu-load'] ?? 0),
        'cpu_count'         => $resource['cpu-count'] ?? 1,
        'cpu_freq'          => $resource['cpu-frequency'] ?? 'N/A',
        'mem_percent'       => $memPercent,
        'used_memory'       => $usedMemory,
        'total_memory'      => $totalMemory,
        'hdd_percent'       => $hddPercent,
        'used_hdd'          => $usedHdd,
        'total_hdd'         => $totalHdd,
        'uptime'            => $resource['uptime'] ?? 'N/A',
        'version'           => $resource['version'] ?? 'N/A',
        'board_name'        => $resource['board-name'] ?? 'CHR',
        'total_interfaces'  => count($interfaceData),
        'active_interfaces' => $activeInterfaces
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error'   => 'Não foi possível conectar ao Mikrotik.'
    ]);
}