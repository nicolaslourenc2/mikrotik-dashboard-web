<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mikrotik Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <header>
        <h1>
            <span class="live-badge" title="Live Mode Ativo"></span>
            Mikrotik Dashboard — <span id="router-name">Carregando...</span>
        </h1>
        <nav>
            <a href="index.php" class="active">Visão Geral</a>
        </nav>
    </header>

    <div class="grid-cards">
        <!-- CPU -->
        <div class="card">
            <h3>Uso da CPU</h3>
            <div class="value" id="cpu-value">0%</div>
            <small style="color: #94a3b8; font-size: 0.8rem;" id="cpu-detail">0 Cores @ -- MHz</small>
            <div class="progress-bar">
                <div class="progress-fill" id="cpu-bar" style="width: 0%;"></div>
            </div>
        </div>

        <!-- RAM -->
        <div class="card">
            <h3>Memória RAM</h3>
            <div class="value" id="ram-value">0%</div>
            <small style="color: #94a3b8; font-size: 0.8rem;" id="ram-detail">0 MB / 0 MB</small>
            <div class="progress-bar">
                <div class="progress-fill" id="ram-bar" style="width: 0%;"></div>
            </div>
        </div>

        <!-- Armazenamento / Flash -->
        <div class="card">
            <h3>Disco / Flash</h3>
            <div class="value" id="hdd-value">0%</div>
            <small style="color: #94a3b8; font-size: 0.8rem;" id="hdd-detail">0 MB / 0 MB</small>
            <div class="progress-bar">
                <div class="progress-fill" id="hdd-bar" style="width: 0%;"></div>
            </div>
        </div>

        <!-- Interfaces -->
        <div class="card">
            <h3>Interfaces de Rede</h3>
            <div class="value" id="iface-value">--</div>
            <small style="color: #94a3b8; font-size: 0.8rem;" id="iface-detail">Ativas / Total</small>
        </div>

        <!-- Uptime -->
        <div class="card">
            <h3>Tempo Ligado (Uptime)</h3>
            <div class="value" style="font-size: 1.2rem; margin-top: 8px;" id="uptime-value">--</div>
        </div>

        <!-- Versão -->
        <div class="card">
            <h3>Versão RouterOS</h3>
            <div class="value" style="font-size: 1.2rem; margin-top: 8px;" id="version-value">--</div>
            <small style="color: #94a3b8; font-size: 0.8rem;" id="board-detail">Hardware: --</small>
        </div>
    </div>

    <script src="assets/js/dashboard.js"></script>
</body>
</html>