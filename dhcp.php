<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mikrotik Dashboard — ARP Leases</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <header>
        <h1>
            <span class="live-badge" title="Live Mode Ativo"></span>
            Mikrotik Dashboard
        </h1>
        <nav>
            <a href="index.php">Visão Geral</a>
            <a href="dhcp.php" class="active">Leases ARP</a>
        </nav>
    </header>

    <div class="table-container">
        <div class="table-header">
            <h2>Dispositivos Conectados (Tabela ARP)</h2>
            <span style="color: #94a3b8; font-size: 0.9rem;">
                Total: <strong id="total-leases" style="color: #38bdf8;">0</strong>
            </span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Endereço IP</th>
                    <th>Endereço MAC</th>
                    <th>Nome do Dispositivo</th>
                    <th>Tipo</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="dhcp-table-body">
                <tr>
                    <td colspan="5" style="text-align: center; color: #94a3b8;">Carregando dispositivos...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="assets/js/arp.js"></script>
</body>
</html>