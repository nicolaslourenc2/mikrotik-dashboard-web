<?php
header('Content-Type: application/json');
require_once('config.php');
require_once('routeros_api.class.php');

$API = new RouterosAPI();

if ($API->connect(MK_HOST, MK_USER, MK_PASS, MK_PORT)) { //variaveis de conexao ao mikrotik
    // Consulta a Tabela ARP do Mikrotik
    $arpEntries = $API->comm('/ip/arp/print');
    $API->disconnect();

    $formattedDevices = [];

    foreach ($arpEntries as $entry) {
        // Ignora entradas incompletas/sem MAC
        if (!isset($entry['mac-address'])) continue;

        $formattedDevices[] = [
            'address'   => $entry['address'] ?? 'N/A',
            'mac'       => $entry['mac-address'] ?? 'N/A',
            'interface' => $entry['interface'] ?? 'N/A',
            'comment'   => $entry['comment'] ?? 'Dispositivo na Rede',
            'dynamic'   => isset($entry['dynamic']) && $entry['dynamic'] == 'true' ? 'Dinâmico' : 'Estático',
            'complete'  => isset($entry['complete']) && $entry['complete'] == 'true' ? 'Ativo' : 'Inativo'
        ];
    }

    echo json_encode([
        'success' => true,
        'count'   => count($formattedDevices),
        'devices' => $formattedDevices
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error'   => 'Não foi possível conectar ao Mikrotik.'
    ]);
}