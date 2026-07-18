<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a Store - BrewHaven Cafe</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

    <style>
        body {
            margin: 0;
            font-family: 'Lato', sans-serif;
            display: flex;
            height: 100vh;
            flex-direction: column;
        }

        /* Header */
        header {
            background-color: #f7f7f7;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            z-index: 1000;
        }
        header h1 {
            margin: 0;
            font-size: 1.5rem;
            color: #2c3e50;
        }
        .back-link {
            text-decoration: none;
            color: #d35400;
            font-weight: bold;
            margin-right: 20px;
        }

        /* Main Layout */
        .container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 350px;
            background: white;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #ddd;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
            z-index: 10;
        }

        .search-area {
            padding: 20px;
            border-bottom: 1px solid #eee;
            background-color: #fafafa;
        }

        .search-box {
            display: flex;
            margin-bottom: 15px;
        }
        .search-box input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            font-family: 'Lato', sans-serif;
        }
        .search-box button {
            padding: 10px 15px;
            background-color: #d35400;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            font-weight: bold;
        }
        .search-box button:hover {
            background-color: #e67e22;
        }

        .geo-btn {
            width: 100%;
            padding: 10px;
            background-color: #fff;
            color: #34495e;
            border: 1px solid #34495e;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }
        .geo-btn:hover {
            background-color: #f1f2f6;
        }

        /* Store List */
        .store-list {
            flex: 1;
            overflow-y: auto;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .store-card {
            padding: 20px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background 0.2s;
        }
        .store-card:hover, .store-card.active {
            background-color: #fff7f2;
        }
        .store-name {
            font-size: 1.1rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .store-details {
            font-size: 0.9rem;
            color: #7f8c8d;
            line-height: 1.4;
        }
        .store-hours {
            margin-top: 8px;
            color: #27ae60;
            font-weight: bold;
            font-size: 0.85rem;
        }

        /* Map */
        #map {
            flex: 1;
            height: 100%;
            z-index: 1;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
            font-style: italic;
        }
    </style>
</head>
<body>

    <header>
        <a href="{{ url('/') }}" class="back-link">← Back</a>
        <h1>Find a Store</h1>
    </header>

    <div class="container">
        <div class="sidebar">
            <div class="search-area">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Enter city, state, or zip...">
                    <button onclick="searchLocation()">Search</button>
                </div>
                <button class="geo-btn" onclick="useMyLocation()">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                    </svg>
                    Use My Current Location
                </button>
            </div>
            
            <ul class="store-list" id="storeList">
                <div class="loading">Loading stores...</div>
            </ul>
        </div>
        
        <div id="map"></div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    
    <script>
        // Initialize Map
        const map = L.map('map').setView([40.730610, -73.935242], 11); // Default to NY
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let stores = [];
        let markers = [];

        // Fetch stores from our API
        fetch('/api/stores')
            .then(response => response.json())
            .then(data => {
                stores = data;
                renderStores(stores);
            });

        function renderStores(storeData) {
            const storeList = document.getElementById('storeList');
            storeList.innerHTML = '';
            
            // Clear existing markers
            markers.forEach(m => map.removeLayer(m));
            markers = [];

            if (storeData.length === 0) {
                storeList.innerHTML = '<div class="loading">No stores found.</div>';
                return;
            }

            storeData.forEach((store, index) => {
                // Add marker to map
                const marker = L.marker([store.latitude, store.longitude])
                    .addTo(map)
                    .bindPopup(`<b>${store.name}</b><br>${store.address}`);
                
                markers.push(marker);

                // Add to sidebar
                const li = document.createElement('li');
                li.className = 'store-card';
                li.innerHTML = `
                    <div class="store-name">${store.name}</div>
                    <div class="store-details">${store.address}, ${store.city}, ${store.state} ${store.zip}</div>
                    <div class="store-details">Phone: ${store.phone || 'N/A'}</div>
                    <div class="store-hours">Open: ${store.hours || 'See store'}</div>
                `;

                // Click event to pan map to store
                li.onclick = () => {
                    // Highlight active
                    document.querySelectorAll('.store-card').forEach(c => c.classList.remove('active'));
                    li.classList.add('active');
                    
                    // Pan map and open popup
                    map.setView([store.latitude, store.longitude], 15);
                    marker.openPopup();
                };

                storeList.appendChild(li);
            });
            
            // Fit map to bounds of all markers if there are any
            if(markers.length > 0) {
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        }

        // 1. Geocoding API Search (Nominatim)
        function searchLocation() {
            const query = document.getElementById('searchInput').value;
            if(!query) return;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const lat = data[0].lat;
                        const lon = data[0].lon;
                        map.setView([lat, lon], 12);
                    } else {
                        alert("Location not found.");
                    }
                });
        }

        // 2. HTML5 Geolocation API
        function useMyLocation() {
            if (navigator.geolocation) {
                document.getElementById('searchInput').value = "Locating...";
                navigator.geolocation.getCurrentPosition(
                    position => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        map.setView([lat, lng], 13);
                        document.getElementById('searchInput').value = "Current Location";
                        
                        // Add a blue marker for user
                        L.circleMarker([lat, lng], {
                            color: '#3388ff',
                            fillColor: '#3388ff',
                            fillOpacity: 0.5,
                            radius: 8
                        }).addTo(map).bindPopup("You are here").openPopup();
                    },
                    error => {
                        alert("Unable to retrieve your location. Please check browser permissions.");
                        document.getElementById('searchInput').value = "";
                    }
                );
            } else {
                alert("Geolocation is not supported by your browser.");
            }
        }
    </script>
</body>
</html>
