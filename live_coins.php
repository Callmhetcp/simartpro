
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Inter, system-ui, -apple-system, sans-serif;
        }

        :root {
            --bg-primary: #1a1a1a;
            --bg-secondary: #222222;
            --text-primary: #F5F5F5;
            --text-secondary: #A9A9A9;
            --accent-positive: #00ff88;
            --accent-negative: #ff3d3d;
            --border-color: #383838;
            --card-bg: #222222;
            --padding-mobile: 12px;
            --padding-desktop: 20px;
            --card-height: 280px;
        }





        .container {
            max-width: 1400px;
            margin: 0 auto;
            overflow: hidden;
            color: #F5F5F5;
        }

        .header {
            margin-bottom: 20px;
            padding: 0 4px;
        }

        .header h1 {
            font-size: 1.5rem;
            margin-bottom: 8px;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .crypto-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: 1fr;
        }

        .crypto-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 16px;
            transition: transform 0.2s;
            height: var(--card-height);
            display: flex;
            flex-direction: column;
        }

        .crypto-card:hover {
            transform: translateY(-2px);
        }

        .coin-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .coin-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .coin-info img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }

        .coin-name-container {
            display: flex;
            flex-direction: column;
        }

        .coin-name {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .coin-symbol {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-top: 2px;
        }

        .coin-rank {
            background: var(--bg-primary);
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .price-container {
            margin: 12px 0;
        }

        .current-price {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .secondary-price {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .stats-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        .stat-item {
            background: var(--bg-primary);
            padding: 12px;
            border-radius: 12px;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.8rem;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 0.95rem;
            font-weight: 500;
        }

        .price-change {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .positive {
            color: var(--accent-positive);
        }

        .negative {
            color: var(--accent-negative);
        }

        .sparkline {
            width: 100%;
            height: 40px;
            margin-top: auto;
            visibility: hidden;
        }

        .error-message {
            text-align: center;
            padding: 20px;
            color: var(--accent-negative);
            background: var(--card-bg);
            border-radius: 16px;
            margin: 20px 0;
        }

        @media (min-width: 320px) {
         

            .crypto-grid {
                margin-inline: 9px;
            }

           
        }
        /* Tablet Styles */
        @media (min-width: 768px) {
            body {
                padding: var(--padding-desktop);
            }

            .crypto-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .header h1 {
                font-size: 2rem;
            }
        }

        /* Desktop Styles */
        @media (min-width: 1200px) {
            .crypto-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Large Desktop Styles */
        @media (min-width: 1600px) {
            .crypto-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Loading Animation */
        .loading-skeleton {
            background: linear-gradient(90deg, var(--card-bg) 25%, var(--bg-secondary) 50%, var(--card-bg) 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 16px;
            height: var(--card-height);
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }
    </style>

    <div class="container" style="margin-bottom: 130px;">
        <header class="header">
            <p>Live cryptocurrency prices and charts</p>
        </header>
        <div id="crypto-data" class="crypto-grid">
            <div class="loading-skeleton"></div>
            <div class="loading-skeleton"></div>
            <div class="loading-skeleton"></div>
        </div>
    </div>

    <script>
        const API_URL = 'https://api.coingecko.com/api/v3';
        const UPDATE_INTERVAL = 30000; // 30 seconds
        const RETRY_DELAY = 60000; // 1 minute retry delay for rate limiting
        let retryTimeout;
        const chartInstances = new Map();

        function formatNumber(num, isCurrency = false) {
            if (!num && num !== 0) return 'N/A';
            if (num >= 1e12) return `$${(num / 1e12).toFixed(2)}T`;
            if (num >= 1e9) return `$${(num / 1e9).toFixed(2)}B`;
            if (num >= 1e6) return `$${(num / 1e6).toFixed(2)}M`;
            if (isCurrency) return `$${num.toFixed(2)}`;
            return num.toFixed(2);
        }

        function createSparkline(canvasId, data, color) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            
            if (chartInstances.has(canvasId)) {
                chartInstances.get(canvasId).destroy();
            }

            const gradient = ctx.createLinearGradient(0, 0, 0, 40);
            gradient.addColorStop(0, `${color}20`);
            gradient.addColorStop(1, `${color}00`);

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Array(data.length).fill(''),
                    datasets: [{
                        data: data,
                        borderColor: color,
                        borderWidth: 2,
                        fill: true,
                        backgroundColor: gradient,
                        tension: 0.4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    }
                }
            });

            chartInstances.set(canvasId, chart);
        }

        async function fetchCryptoData() {
            try {
                const response = await fetch(`${API_URL}/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=12&sparkline=true&price_change_percentage=24h`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (response.status === 429) {
                    throw new Error('Rate limit exceeded. Please wait a moment.');
                }

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                return await response.json();
            } catch (error) {
                console.error('Error fetching data:', error.message);
                const container = document.getElementById('crypto-data');
                container.innerHTML = `
                    <div class="error-message">
                        ${error.message === 'Rate limit exceeded. Please wait a moment.' 
                            ? 'Rate limit reached. Retrying in 1 minute...' 
                            : 'Error loading data. Retrying...'}
                    </div>
                `;
                return null;
            }
        }

        function updateUI(cryptoData) {
            if (!cryptoData) return;

            const container = document.getElementById('crypto-data');
            container.innerHTML = '';

            cryptoData.forEach((coin, index) => {
                const priceChangeClass = coin.price_change_percentage_24h >= 0 ? 'positive' : 'negative';
                const priceChangeSymbol = coin.price_change_percentage_24h >= 0 ? '+' : '';
                const chartColor = coin.price_change_percentage_24h >= 0 ? '#00ff88' : '#ff4d4d';
                const canvasId = `chart-${coin.id}`;

                const card = document.createElement('div');
                card.className = 'crypto-card';
                card.innerHTML = `
                    <div class="coin-header">
                        <div class="coin-info">
                            <img src="${coin.image}" alt="${coin.name}" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22><rect width=%2224%22 height=%2224%22 fill=%22%23ccc%22/></svg>'">
                            <div class="coin-name-container">
                                <span class="coin-name">${coin.name}</span>
                                <span class="coin-symbol">${coin.symbol.toUpperCase()}</span>
                            </div>
                        </div>
                        <span class="coin-rank">#${index + 1}</span>
                    </div>
                    
                    <div class="price-container">
                        <div class="current-price">${formatNumber(coin.current_price, true)}</div>
                        <div class="secondary-price">₿ ${coin.current_price / cryptoData[0].current_price}</div>
                    </div>

                    <div class="stats-container">
                        <div class="stat-item">
                            <div class="stat-label">Market Cap</div>
                            <div class="stat-value">${formatNumber(coin.market_cap)}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">24h Volume</div>
                            <div class="stat-value">${formatNumber(coin.total_volume)}</div>
                        </div>
                    </div>

                    <div class="price-change ${priceChangeClass}">
                        ${priceChangeSymbol}${coin.price_change_percentage_24h?.toFixed(2) || '0.00'}%
                    </div>

                    <canvas id="${canvasId}" class="sparkline"></canvas>
                `;

                container.appendChild(card);

                if (coin.sparkline_in_7d && coin.sparkline_in_7d.price) {
                    createSparkline(canvasId, coin.sparkline_in_7d.price, chartColor);
                }
            });
        }

        async function initializeAndUpdate() {
            const data = await fetchCryptoData();
            if (data) {
                updateUI(data);
                clearTimeout(retryTimeout);
                retryTimeout = setTimeout(initializeAndUpdate, UPDATE_INTERVAL);
            } else {
                clearTimeout(retryTimeout);
                retryTimeout = setTimeout(initializeAndUpdate, RETRY_DELAY);
            }
        }

        initializeAndUpdate();

        window.addEventListener('unload', () => {
            clearTimeout(retryTimeout);
            chartInstances.forEach(chart => chart.destroy());
            chartInstances.clear();
        });
    </script>
