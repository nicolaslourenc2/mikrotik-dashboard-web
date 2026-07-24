async function loadArpDevices() {
    try {
        const response = await fetch('api_dhcp.php'); // Ou api_arp.php
        const data = await response.json();

        if (!data.success) {
            console.error(data.error);
            return;
        }

        document.getElementById('total-leases').innerText = data.count;
        const tbody = document.getElementById('dhcp-table-body');
        tbody.innerHTML = '';

        if (data.devices.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">Nenhum dispositivo encontrado na Tabela ARP.</td></tr>';
            return;
        }

        data.devices.forEach(device => {
            const statusClass = device.complete === 'Ativo' ? 'badge-bound' : 'badge-waiting';
            const typeClass = device.dynamic === 'Estático' ? 'badge-static' : 'badge-dynamic';

            const row = `
                <tr>
                    <td><strong>${device.address}</strong></td>
                    <td style="font-family: monospace; color: #94a3b8;">${device.mac}</td>
                    <td><span class="badge badge-dynamic">${device.interface}</span></td>
                    <td><span class="badge ${typeClass}">${device.dynamic}</span></td>
                    <td><span class="badge ${statusClass}">${device.complete}</span></td>
                </tr>
            `;
            tbody.innerHTML += row;
        });

    } catch (err) {
        console.error("Erro ao carregar dispositivos ARP:", err);
    }
}

loadArpDevices();
setInterval(loadArpDevices, 5000);