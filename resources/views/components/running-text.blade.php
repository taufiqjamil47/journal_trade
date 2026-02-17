<div class="running-text-container py-2" id="runningTextContainer">
    <div class="running-text-wrapper">
        <div class="running-text" id="runningText">
            <!-- Data pair akan di-generate oleh JavaScript -->
        </div>
    </div>
</div>

<style>
    /* Styling untuk running text */
    .running-text-container {
        background: rgba(13, 22, 39, 0.95);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(14, 165, 233, 0.3);
        overflow: hidden;
        position: sticky;
        top: 0;
        z-index: 100;
        transition: all 0.3s ease;
    }

    .running-text-wrapper {
        display: flex;
        width: max-content;
    }

    .running-text {
        display: flex;
        animation: scrollText 60s linear infinite;
        white-space: nowrap;
    }

    .running-text:hover {
        animation-play-state: paused;
    }

    .currency-pair {
        display: flex;
        align-items: center;
        margin: 0 2px;
        padding: 2px 16px;
        background: rgba(14, 165, 233, 0.1);
        /* border: 1px solid rgba(14, 165, 233, 0.3); */
        transition: all 0.3s ease;
        flex-shrink: -1;
    }

    .dark .currency-pair {
        background: rgba(14, 165, 233, 0.1);
    }

    .currency-pair.up {
        border-color: rgba(16, 185, 129, 0.5);
        background: rgba(16, 185, 129, 0.1);
    }

    .currency-pair.down {
        border-color: rgba(239, 68, 68, 0.5);
        background: rgba(239, 68, 68, 0.1);
    }

    .up {
        color: #10b981;
    }

    .down {
        color: #ef4444;
    }

    .price-change {
        font-size: 0.75rem;
        font-weight: 600;
    }

    .price-up {
        animation: priceUp 0.5s ease;
    }

    .price-down {
        animation: priceDown 0.5s ease;
    }

    @keyframes priceUp {
        0% {
            background-color: transparent;
        }

        50% {
            background-color: rgba(16, 185, 129, 0.3);
        }

        100% {
            background-color: transparent;
        }
    }

    @keyframes priceDown {
        0% {
            background-color: transparent;
        }

        50% {
            background-color: rgba(239, 68, 68, 0.3);
        }

        100% {
            background-color: transparent;
        }
    }
</style>

<script>
    // Data pair forex dengan format yang lebih detail
    const forexPairs = [{
            pair: "XAUUSD",
            price: 1985.42,
            change: 12.35,
            direction: "up",
            decimal: 2
        },
        {
            pair: "GBPUSD",
            price: 1.2650,
            change: 0.0032,
            direction: "up",
            decimal: 4
        },
        {
            pair: "EURUSD",
            price: 1.0925,
            change: -0.0015,
            direction: "down",
            decimal: 4
        },
        {
            pair: "USDJPY",
            price: 147.85,
            change: 0.45,
            direction: "up",
            decimal: 2
        },
        {
            pair: "AUDUSD",
            price: 0.6580,
            change: -0.0021,
            direction: "down",
            decimal: 4
        },
        {
            pair: "USDCAD",
            price: 1.3520,
            change: 0.0018,
            direction: "up",
            decimal: 4
        },
        {
            pair: "NZDUSD",
            price: 0.6125,
            change: -0.0010,
            direction: "down",
            decimal: 4
        },
        {
            pair: "USDCHF",
            price: 0.8820,
            change: 0.0005,
            direction: "up",
            decimal: 4
        },
        {
            pair: "EURGBP",
            price: 0.8630,
            change: -0.0008,
            direction: "down",
            decimal: 4
        },
        {
            pair: "XAGUSD",
            price: 23.15,
            change: 0.42,
            direction: "up",
            decimal: 2
        },
        {
            pair: "USDTRY",
            price: 26.45,
            change: -0.15,
            direction: "down",
            decimal: 2
        },
        {
            pair: "USDMXN",
            price: 18.75,
            change: 0.10,
            direction: "up",
            decimal: 2
        },
        {
            pair: "EURJPY",
            price: 161.50,
            change: -0.30,
            direction: "down",
            decimal: 2
        },
        {
            pair: "GBPJPY",
            price: 187.20,
            change: 0.25,
            direction: "up",
            decimal: 2
        },
        {
            pair: "COIN",
            price: 124.85,
            change: -0.12,
            direction: "down",
            decimal: 2
        },
        {
            pair: "IDX30",
            price: 6350.25,
            change: 15.75,
            direction: "up",
            decimal: 2
        },
        {
            pair: "NAS100",
            price: 13450.50,
            change: -25.30,
            direction: "down",
            decimal: 2
        }
    ];

    // Data real-time untuk setiap pair
    const realTimeData = {};

    // Inisialisasi data real-time
    forexPairs.forEach(pair => {
        realTimeData[pair.pair] = {
            ...pair
        };
    });

    // Fungsi untuk generate perubahan harga random
    function generateRandomChange(currentPrice, decimalPlaces) {
        const volatility = decimalPlaces === 2 ? 0.5 : 0.0005;
        const change = (Math.random() - 0.5) * volatility * 2;

        const newPrice = currentPrice + change;
        const roundedPrice = Math.round(newPrice * Math.pow(10, decimalPlaces)) / Math.pow(10, decimalPlaces);

        return {
            price: roundedPrice,
            change: Math.abs(change),
            direction: change >= 0 ? "up" : "down"
        };
    }

    // Fungsi untuk membuat elemen pair
    function createPairElement(pairData, index) {
        const pairDiv = document.createElement('div');
        pairDiv.className = `currency-pair ${pairData.direction}`;
        pairDiv.setAttribute('data-pair', pairData.pair);
        pairDiv.setAttribute('data-index', index);

        const directionIcon = pairData.direction === 'up' ? 'fa-arrow-up' : 'fa-arrow-down';
        const changeClass = pairData.direction === 'up' ? 'up' : 'down';

        pairDiv.innerHTML = `
                <span class="font-semibold text-xs text-white mr-3">${pairData.pair}</span>
                <span class="text-xs ${changeClass} mr-3 flex items-center change-value">
                    <i class="fas ${directionIcon} mr-1"></i>
                    ${pairData.change.toFixed(pairData.decimal)}
                </span>
                <span class="font-semibold text-xs price-value">${pairData.price.toFixed(pairData.decimal)}</span>
            `;

        return pairDiv;
    }

    // Fungsi untuk update harga secara real-time
    function updatePrices() {
        Object.keys(realTimeData).forEach(pairName => {
            const pair = realTimeData[pairName];
            const newData = generateRandomChange(pair.price, pair.decimal);

            // Update data real-time
            realTimeData[pairName].price = newData.price;
            realTimeData[pairName].change = newData.change;
            realTimeData[pairName].direction = newData.direction;

            // Update semua elemen dengan pair yang sama
            const pairElements = document.querySelectorAll(`[data-pair="${pairName}"]`);

            pairElements.forEach(pairElement => {
                // Update class untuk warna background
                pairElement.className = `currency-pair ${newData.direction}`;

                // Update icon dan perubahan
                const directionIcon = newData.direction === 'up' ? 'fa-arrow-up' : 'fa-arrow-down';
                const changeClass = newData.direction === 'up' ? 'up' : 'down';

                const changeElement = pairElement.querySelector('.change-value');
                changeElement.className = `text-xs ${changeClass} mr-3 flex items-center change-value`;
                changeElement.innerHTML = `
                        <i class="fas ${directionIcon} mr-1"></i>
                        ${newData.change.toFixed(pair.decimal)}
                    `;

                // Update harga dengan animasi
                const priceElement = pairElement.querySelector('.price-value');
                priceElement.classList.remove('price-up', 'price-down');
                void priceElement.offsetWidth; // Trigger reflow
                priceElement.classList.add(newData.direction === 'up' ? 'price-up' : 'price-down');

                // Update harga
                priceElement.textContent = newData.price.toFixed(pair.decimal);
            });
        });
    }

    // Fungsi untuk mengisi running text
    function populateRunningText() {
        const runningText = document.getElementById('runningText');

        // Duplikasi data untuk efek scroll yang smooth (4 set agar infinite)
        const duplicatedPairs = [];
        for (let i = 0; i < 2; i++) {
            forexPairs.forEach(pair => {
                duplicatedPairs.push({
                    ...pair
                });
            });
        }

        duplicatedPairs.forEach((pair, index) => {
            const pairElement = createPairElement(pair, index);
            runningText.appendChild(pairElement);
        });
    }

    // Panggil fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        populateRunningText();

        // Update harga setiap 2 detik
        setInterval(updatePrices, 2000);
    });
</script>
