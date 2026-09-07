# 🌐 MikroTik Live Dashboard

Dashboard web em tempo real para monitoramento de métricas de hardware, status de recursos e interfaces de rede via API nativa do MikroTik RouterOS.

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![RouterOS](https://img.shields.io/badge/MikroTik-RouterOS-004B87?style=for-the-badge)
![License](https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge)

---

## Visão Geral

Aplicação desenvolvida para fornecer uma interface gráfica moderna, responsiva e com suporte a *Live Mode* para acompanhamento contínuo da saúde operacional de dispositivos MikroTik RouterOS, eliminando a necessidade de acesso via Winbox ou SSH para checagens de rotina.

### Recursos Monitorados
- **Uso de CPU:** Carga percentual, quantidade de núcleos ativos e frequência de operação (MHz).
- **Memória RAM:** Consumo percentual com indicador em barra de progresso e detalhamento em megabytes (utilizada / total).
- **Armazenamento (Flash / HDD):** Ocupação de disco com cálculo percentual e valores em MB.
- **Interfaces de Rede:** Contagem de interfaces ativas (*running*) em relação ao total configurado.
- **Identificação & Sistema:** Modelo de hardware (RouterBOARD), versão do RouterOS instalada e tempo de atividade ininterrupto (*Uptime*).

---

## Tecnologias Utilizadas

- **Backend:** PHP nativo consumindo a API oficial do RouterOS via conexão Socket (`RouterosAPI`).
- **Frontend:** HTML5 semântico, CSS3 Moderno (Dark Theme com CSS Grid/Flexbox) e JavaScript Vanilla assíncrono (`fetch` API).

---

## Pré-requisitos

1. **Serviço de API ativo no RouterOS:**
   ```routeros
   /ip service enable api