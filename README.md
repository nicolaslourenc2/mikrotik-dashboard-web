# MikroTik Live Dashboard

Painel web em tempo real para monitoramento de telemetria, integridade de hardware e status de interfaces de roteadores MikroTik RouterOS via API socket nativa.

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![RouterOS](https://img.shields.io/badge/MikroTik-RouterOS-004B87?style=for-the-badge)
![License](https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge)

---

## Sobre o Projeto

O **MikroTik Live Dashboard** foi projetado para centralizar e simplificar a observabilidade de ativos de rede MikroTik. A aplicação dispensa o uso constante de clientes proprietários pesados (como Winbox ou sessões interativas de SSH) para auditorias de rotina, entregando uma interface leve, reativa e acessível via navegador.

A solução funciona como um middleware de telemetria: conecta-se ao RouterOS, consome métricas de baixo nível via comandos nativos de terminal, normaliza os dados em JSON e entrega atualizações assíncronas no frontend em ciclos constantes de amostragem.

---

## Arquitetura e Funcionamento

[ MikroTik RouterOS ]
        │  (TCP Socket / Porta 8728 - Protocolo Binário RouterOS)
        ▼
   [ api.php ]  ─── Consome socket, processa bytes e calcula percentuais
        │  (HTTP / JSON Payload)
        ▼
[ JavaScript Client ] ─── Polling assíncrono (3s) + Renderização DOM reativa

## Principais Módulos
Camada de Transporte (routeros_api.class.php): Comunicação direta em nível de socket TCP, lidando com autenticação e o protocolo de palavras (words) do RouterOS.

Camada de Apresentação (index.php + Vanilla JS/CSS): Interface dark responsiva utilizando CSS Grid nativo, feedback visual pulsante do estado da conexão e atualização dinâmica sem recarregamento de página.

## Métricas Monitoradas
Processamento (CPU): Percentual de carga em tempo real, contagem de núcleos e frequência nominal de operação.

Memória RAM: Cálculo dinâmico de consumo total vs. alocado com barra de saturação proporcional.

Armazenamento: Ocupação de disco/flash com conversão direta de bytes para MB.

Topologia de Rede: Monitoramento de interfaces ativas com flag running=true versus interfaces provisionadas.

Metadados de Sistema: Modelo da placa (RouterBOARD/CHR), versão de firmware e uptime contínuo.

## Instalação e Configuração
1. Requisitos do MikroTik
Habilite o serviço de API na porta padrão (8728) e crie um usuário dedicado com privilégios apenas de leitura:


## 2. Configuração da Aplicação
1. Clone este repositório no diretório do seu servidor web (Apache/Nginx com suporte a PHP 7.4+):

```
git clone [https://github.com/nicolaslourenc/mikrotik-dashboard.git](https://github.com/nicolaslourenc/mikrotik-dashboard.git)
cd mikrotik-dashboard
```
2. Duplique o arquivo de exemplo e defina as credenciais de acesso:
```cp config.example.php config.php```

3. Edite o config.php com os dados do seu ambiente:

```
define('MK_HOST', '192.168.88.1');
define('MK_USER', 'usr_dashboard');
define('MK_PASS', 'SUA_SENHA_SEGURA');
define('MK_PORT', 8728);
```

4. Acesse http://localhost/mikrotik-dashboard pelo navegador.

## Metodologia de Desenvolvimento
Projeto 100% desenvolvido utilizando ajuda de LLMs e em laboratório para estudo/entendimento de:
- Consumo de utilização de APIs
- Monitoramento de como o mikrotik gerencia seus recursos
- Atualização em tempo real dos dados utilizando JS
- Criação de um front-end para um projeto real
