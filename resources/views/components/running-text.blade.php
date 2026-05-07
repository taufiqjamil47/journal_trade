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
    // Konfigurasi currency pairs untuk di-fetch dari Frankfurter API
    const currencyPairs = [{
            base: 'EUR',
            quote: 'USD'
        },
        {
            base: 'GBP',
            quote: 'USD'
        },
        {
            base: 'USD',
            quote: 'JPY'
        },
        {
            base: 'AUD',
            quote: 'USD'
        },
        {
            base: 'USD',
            quote: 'CAD'
        },
        {
            base: 'NZD',
            quote: 'USD'
        },
        {
            base: 'USD',
            quote: 'CHF'
        },
        {
            base: 'EUR',
            quote: 'GBP'
        },
        {
            base: 'EUR',
            quote: 'JPY'
        },
        {
            base: 'GBP',
            quote: 'JPY'
        },
        {
            base: 'AUD',
            quote: 'CAD'
        },
        {
            base: 'USD',
            quote: 'MXN'
        },
        {
            base: 'USD',
            quote: 'TRY'
        },
        {
            base: 'EUR',
            quote: 'CAD'
        },
        {
            base: 'EUR',
            quote: 'AUD'
        }
    ];

    // Data real-time untuk setiap pair
    const realTimeData = {};

    // Inisialisasi data dengan loading state
    currencyPairs.forEach(pair => {
        const pairName = `${pair.base}${pair.quote}`;
        realTimeData[pairName] = {
            base: pair.base,
            quote: pair.quote,
            pair: pairName,
            price: null,
            change: 0,
            direction: 'up',
            previousPrice: null,
            decimal: pairName.includes('JPY') ? 2 : 4
        };
    });

    // Fungsi untuk fetch rates dari Frankfurter API
    async function fetchRatesFromFrankfurter() {
        try {
            const quotes = currencyPairs.map(p => p.quote).join(',');
            const bases = [...new Set(currencyPairs.map(p => p.base))];

            const promises = bases.map(base => {
                const apiUrl = `https://api.frankfurter.dev/v2/rates?base=${base}&quotes=${quotes}`;
                return fetch(apiUrl).then(r => r.json());
            });

            const responses = await Promise.all(promises);

            responses.forEach(response => {
                if (response && Array.isArray(response)) {
                    response.forEach(rate => {
                        const pairName = `${rate.base}${rate.quote}`;
                        if (realTimeData[pairName]) {
                            // Simpan harga sebelumnya untuk perhitungan change
                            realTimeData[pairName].previousPrice = realTimeData[pairName].price ||
                                rate.rate;

                            // Gunakan harga dari API sebagai base, tapi tambahkan sedikit variasi untuk simulasi real-time
                            const basePrice = rate.rate;
                            const volatility = pairName.includes('JPY') ? 0.01 :
                                0.0001; // Volatilitas lebih kecil untuk JPY
                            const randomChange = (Math.random() - 0.5) * volatility * 2;
                            realTimeData[pairName].price = basePrice + randomChange;
                        }
                    });
                }
            });

            updateUIWithData();
        } catch (error) {
            console.error('Error fetching rates:', error);
        }
    }

    // Fungsi untuk update harga secara real-time dengan variasi kecil
    function updatePricesRealTime() {
        Object.keys(realTimeData).forEach(pairName => {
            const pair = realTimeData[pairName];
            if (pair.price === null) return;

            // Simpan harga sebelumnya
            pair.previousPrice = pair.price;

            // Tambahkan variasi kecil untuk simulasi real-time
            const volatility = pairName.includes('JPY') ? 0.001 :
                0.00001; // Variasi lebih kecil untuk update real-time
            const randomChange = (Math.random() - 0.5) * volatility * 2;
            pair.price += randomChange;

            // Pastikan harga tidak negatif
            pair.price = Math.max(pair.price, 0.0001);
        });

        updateUIWithData();
    }

    function createPairElement(pairData, index) {
        if (pairData.price === null) {
            return null; // Skip jika data belum tersedia
        }

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

    // Fungsi untuk update UI dengan data dari API
    function updateUIWithData() {
        const runningText = document.getElementById('runningText');

        // Jika belum ada elemen, buat untuk pertama kali
        if (runningText.children.length === 0) {
            populateRunningText();
        } else {
            // Update elemen yang sudah ada
            Object.keys(realTimeData).forEach(pairName => {
                const pair = realTimeData[pairName];

                // Hitung perubahan dari harga sebelumnya
                if (pair.previousPrice !== null && pair.price !== null) {
                    const change = pair.price - pair.previousPrice;
                    pair.change = Math.abs(change);
                    pair.direction = change >= 0 ? 'up' : 'down';
                } else {
                    // Jika tidak ada previous price, set change ke 0
                    pair.change = 0;
                    pair.direction = 'up';
                }

                // Update semua elemen dengan pair yang sama
                const pairElements = document.querySelectorAll(`[data-pair="${pairName}"]`);

                pairElements.forEach(pairElement => {
                    // Update class untuk warna background
                    pairElement.className = `currency-pair ${pair.direction}`;

                    // Update icon dan perubahan
                    const directionIcon = pair.direction === 'up' ? 'fa-arrow-up' : 'fa-arrow-down';
                    const changeClass = pair.direction === 'up' ? 'up' : 'down';

                    const changeElement = pairElement.querySelector('.change-value');
                    changeElement.className =
                        `text-xs ${changeClass} mr-3 flex items-center change-value`;
                    changeElement.innerHTML = `
                            <i class="fas ${directionIcon} mr-1"></i>
                            ${pair.change.toFixed(pair.decimal)}
                        `;

                    // Update harga dengan animasi
                    const priceElement = pairElement.querySelector('.price-value');
                    priceElement.classList.remove('price-up', 'price-down');
                    void priceElement.offsetWidth; // Trigger reflow
                    priceElement.classList.add(pair.direction === 'up' ? 'price-up' : 'price-down');

                    // Update harga
                    priceElement.textContent = pair.price.toFixed(pair.decimal);
                });
            });
        }
    }

    // Fungsi untuk mengisi running text
    function populateRunningText() {
        const runningText = document.getElementById('runningText');
        runningText.innerHTML = ''; // Clear existing

        // Filter pair yang sudah memiliki data
        const pairsWithData = Object.values(realTimeData).filter(p => p.price !== null);

        // Duplikasi data untuk efek scroll yang smooth
        const duplicatedPairs = [];
        for (let i = 0; i < 2; i++) {
            pairsWithData.forEach(pair => {
                duplicatedPairs.push({
                    ...pair
                });
            });
        }

        duplicatedPairs.forEach((pair, index) => {
            const pairElement = createPairElement(pair, index);
            if (pairElement) {
                runningText.appendChild(pairElement);
            }
        });
    }

    // Panggil fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch data pertama kali dari API
        fetchRatesFromFrankfurter();

        // Update harga setiap 20 detik dari API untuk refresh base price
        setInterval(fetchRatesFromFrankfurter, 20000);

        // Update harga secara real-time setiap 20 detik dengan variasi kecil
        setInterval(updatePricesRealTime, 20000);
    });
</script>
