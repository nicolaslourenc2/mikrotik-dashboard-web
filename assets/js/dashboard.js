async function updateDashboard() {
    try {
        const response = await fetch('api.php');
        const data = await response.json();

        if (!data.success) {
            console.error(data.error);
            return;
        }

        // Nome
        document.getElementById('router-name').innerText = data.identity;
        
        // CPU
        document.getElementById('cpu-value').innerText = data.cpu_load + '%';
        document.getElementById('cpu-bar').style.width = data.cpu_load + '%';
        document.getElementById('cpu-detail').innerText = `${data.cpu_count} Core(s) @ ${data.cpu_freq} MHz`;

        // RAM
        document.getElementById('ram-value').innerText = data.mem_percent + '%';
        document.getElementById('ram-bar').style.width = data.mem_percent + '%';
        document.getElementById('ram-detail').innerText = `${data.used_memory} MB / ${data.total_memory} MB`;

        // DISCO
        document.getElementById('hdd-value').innerText = data.hdd_percent + '%';
        document.getElementById('hdd-bar').style.width = data.hdd_percent + '%';
        document.getElementById('hdd-detail').innerText = `${data.used_hdd} MB / ${data.total_hdd} MB`;

        // INTERFACES
        document.getElementById('iface-value').innerText = `${data.active_interfaces} / ${data.total_interfaces}`;

        // UPTIME E VERSÃO
        document.getElementById('uptime-value').innerText = data.uptime;
        document.getElementById('version-value').innerText = 'v' + data.version;
        document.getElementById('board-detail').innerText = 'Model: ' + data.board_name;

    } catch (err) {
        console.error("Erro ao buscar dados do Live Mode:", err);
    }
}

updateDashboard();
setInterval(updateDashboard, 1000);