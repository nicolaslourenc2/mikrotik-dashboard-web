<?php
require_once('config.php');
require_once('routeros_api.class.php');

$API = new RouterosAPI();
$API->debug = false;

echo "<h1>Status do Mikrotikson da silva</h1>";
echo "<p>Informações do Mikrotik conectado via API para <b>tecnotam</b>:</p>";

if ($API->connect(MK_HOST, MK_USER, MK_PASS, MK_PORT)) {
    
    // Busca informações de recursos do sistema
    $systemResource = $API->comm("/system/resource/print");
    
    if (!empty($systemResource)) {
        $info = $systemResource[0];
        
        echo "<ul style='font-family: sans-serif; line-height: 1.6;'>";
        echo "<li><strong>Identificação / Modelo:</strong> " . ($info['board-name'] ?? 'N/A') . "</li>";
        echo "<li><strong>Versão do RouterOS:</strong> " . ($info['version'] ?? 'N/A') . "</li>";
        echo "<li><strong>Tempo Online (Uptime):</strong> " . ($info['uptime'] ?? 'N/A') . "</li>";
        echo "<li><strong>Uso de CPU:</strong> " . ($info['cpu-load'] ?? 0) . "%</li>";
        echo "<li><strong>Memória Livre:</strong> " . round(($info['free-memory'] ?? 0) / 1024 / 1024, 2) . " MB</li>";
        echo "<li><strong>Memória Total:</strong> " . round(($info['total-memory'] ?? 0) / 1024 / 1024, 2) . " MB</li>";
        echo "<li><strong>Armazenamento Livre:</strong> " . round(($info['free-hdd-space'] ?? 0) / 1024 / 1024, 2) . " MB</li>";
        echo "<li><strong>Armazenamento Total:</strong> " . round(($info['total-hdd-space'] ?? 0) / 1024 / 1024, 2) . " MB</li>";
        echo "<li><strong>Arquitetura do Sistema:</strong> " . ($info['architecture-name'] ?? 'N/A') . "</li>";
        echo "<li><strong>Versão do Kernel:</strong> " . ($info['kernel-version'] ?? 'N/A') . "</li>";
        echo "<li><strong>Versão do Bootloader:</strong> " . ($info['boot-loader'] ?? 'N/A') . "</li>";
        echo "<li><strong>Versão do Firmware:</strong> " . ($info['firmware-type'] ?? 'N/A') . "</li>";
        echo "<li><strong>Versão do RouterBOOT:</strong> " . ($info['routerboot-version'] ?? 'N/A') . "</li>";
        echo "<li><strong>Versão do RouterOS (Long-term):</strong> " . ($info['long-term'] ?? 'N/A') . "</li>";
        echo "<li><strong>Versão do RouterOS (Current):</strong> " . ($info['current'] ?? 'N/A') . "</li>";
        echo "</ul>";
    }

    $API->disconnect();
} else {
    echo "<p style='color: red;'>Erro ao conectar no Mikrotik. Verifique o IP, credenciais ou se o serviço 'api' está ativo no RouterOS (IP > Services).</p>";
}