<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            transition: background 1.5s ease;
            overflow: hidden;
            position: relative;
        }

        /* Dynamic backgrounds with animations */
        body.clear { 
            background: linear-gradient(120deg, #89f7fe 0%, #66a6ff 100%);
        }
        body.clouds { 
            background: linear-gradient(to top, #D7D2CC 0%, #304352 100%);
        }
        body.rain { 
            background: linear-gradient(to top, #4B79A1 0%, #283E51 100%);
        }
        body.snow { 
            background: linear-gradient(to top, #83a4d4 0%, #b6fbff 100%);
        }
        body.thunderstorm { 
            background: linear-gradient(to top, #0f2027 0%, #203a43 50%, #2c5364 100%);
        }
        body.mist { 
            background: linear-gradient(to top, #606c88 0%, #3f4c6b 100%);
        }

        /* Animated background elements */
        .weather-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }

        /* Sun animation for clear weather */
        .sun {
            position: absolute;
            top: 50px;
            right: 100px;
            width: 80px;
            height: 80px;
            background: #ffde65;
            border-radius: 50%;
            box-shadow: 0 0 50px #ffde65, 0 0 100px #ffde65;
            animation: sunPulse 4s infinite alternate;
        }

        @keyframes sunPulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }

        /* Cloud animations */
        .cloud {
            position: absolute;
            background: white;
            border-radius: 50%;
            opacity: 0.9;
        }

        .cloud1 {
            width: 100px;
            height: 40px;
            top: 80px;
            left: 10%;
            animation: moveCloud 25s linear infinite;
        }

        .cloud2 {
            width: 120px;
            height: 50px;
            top: 150px;
            left: 60%;
            animation: moveCloud 30s linear infinite;
        }

        .cloud3 {
            width: 80px;
            height: 30px;
            top: 200px;
            left: 30%;
            animation: moveCloud 40s linear infinite;
        }

        @keyframes moveCloud {
            0% { transform: translateX(-100px); }
            100% { transform: translateX(calc(100vw + 100px)); }
        }

        /* Rain animation */
        .rain-drop {
            position: absolute;
            width: 2px;
            height: 25px;
            background: linear-gradient(to bottom, transparent, #a3d5ff);
            border-radius: 0 0 5px 5px;
            opacity: 0.6;
        }

        /* Snowflake animation */
        .snowflake {
            position: absolute;
            color: white;
            opacity: 0.8;
            font-size: 16px;
        }

        /* Main container */
        .weather-app {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            padding: 32px;
            width: 100%;
            max-width: 450px;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .weather-app:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 36px 0 rgba(31, 38, 135, 0.25);
        }

        /* Header and title */
        .app-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        h1 {
            font-weight: 700;
            font-size: 28px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .refresh-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .refresh-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(180deg);
        }

        /* Search form */
        .search-form {
            display: flex;
            margin-bottom: 28px;
            position: relative;
        }

        .search-input {
            flex: 1;
            padding: 16px 52px 16px 20px;
            border: none;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 16px;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5);
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-btn {
            position: absolute;
            right: 6px;
            top: 6px;
            background: rgba(255, 255, 255, 0.3);
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        /* Weather display */
        .weather-display {
            text-align: center;
        }

        .location {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .date {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .weather-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto;
            position: relative;
        }

        .temperature {
            font-size: 64px;
            font-weight: 700;
            margin: 10px 0;
            line-height: 1;
        }

        .description {
            font-size: 20px;
            margin-bottom: 24px;
            text-transform: capitalize;
        }

        /* Weather details */
        .weather-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-top: 24px;
        }

        .detail-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: all 0.3s ease;
        }

        .detail-card:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }

        .detail-icon {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 18px;
            font-weight: 600;
        }

        .detail-label {
            font-size: 12px;
            opacity: 0.8;
        }

        /* Error message */
        .error-message {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            margin-top: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .weather-app {
                padding: 24px;
            }
            
            .temperature {
                font-size: 56px;
            }
            
            .weather-details {
                grid-template-columns: 1fr;
            }
        }

        /* Animation for elements */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
</head>
<body class="{{ $weather ? strtolower($weather['weather'][0]['main']) : 'clear' }}">
    <!-- Animated background elements -->
    <div class="weather-bg">
        @if($weather && $weather['weather'][0]['main'] == 'Clear')
            <div class="sun"></div>
            <div class="cloud cloud1"></div>
            <div class="cloud cloud2"></div>
            <div class="cloud cloud3"></div>
        @endif
        
        @if($weather && $weather['weather'][0]['main'] == 'Clouds')
            <div class="cloud cloud1"></div>
            <div class="cloud cloud2"></div>
            <div class="cloud cloud3"></div>
            <div class="cloud" style="width: 90px; height: 35px; top: 100px; left: 40%;"></div>
            <div class="cloud" style="width: 70px; height: 25px; top: 180px; left: 20%;"></div>
        @endif
        
        @if($weather && $weather['weather'][0]['main'] == 'Rain')
            <!-- Raindrops will be generated by JavaScript -->
        @endif
    </div>

    <div class="weather-app">
        <div class="app-header">
            <h1>Weather Dashboard</h1>
            <button class="refresh-btn" id="refreshBtn">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>

        <form method="GET" action="{{ url('/') }}" class="search-form">
            <input type="text" name="city" placeholder="Enter city name" value="{{ $city }}" class="search-input">
            <button type="submit" class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </form>

        @if($weather)
            <div class="weather-display">
                <h2 class="location">{{ $weather['name'] }}, {{ $weather['sys']['country'] }}</h2>
                <p class="date">{{ date('l, F j, Y') }}</p>
                
                <div class="weather-icon">
                    <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@2x.png" 
                         alt="{{ $weather['weather'][0]['description'] }}">
                </div>
                
                <p class="temperature">{{ round($weather['main']['temp']) }}°C</p>
                <p class="description">{{ $weather['weather'][0]['description'] }}</p>
                
                <div class="weather-details">
                    <div class="detail-card">
                        <div class="detail-icon"><i class="fas fa-temperature-high"></i></div>
                        <div class="detail-value">{{ $weather['main']['feels_like'] }}°C</div>
                        <div class="detail-label">Feels Like</div>
                    </div>
                    
                    <div class="detail-card">
                        <div class="detail-icon"><i class="fas fa-tint"></i></div>
                        <div class="detail-value">{{ $weather['main']['humidity'] }}%</div>
                        <div class="detail-label">Humidity</div>
                    </div>
                    
                    <div class="detail-card">
                        <div class="detail-icon"><i class="fas fa-wind"></i></div>
                        <div class="detail-value">{{ $weather['wind']['speed'] }} m/s</div>
                        <div class="detail-label">Wind Speed</div>
                    </div>
                    
                    <div class="detail-card">
                        <div class="detail-icon"><i class="fas fa-compress-alt"></i></div>
                        <div class="detail-value">{{ $weather['main']['pressure'] }} hPa</div>
                        <div class="detail-label">Pressure</div>
                    </div>
                </div>
            </div>
        @else
            <div class="error-message">
                <i class="fas fa-exclamation-circle" style="font-size: 48px; margin-bottom: 16px;"></i>
                <p>No weather data found. Please try another city.</p>
            </div>
        @endif
    </div>

    <script>
        // Add animations for weather elements
        document.addEventListener('DOMContentLoaded', function() {
            // Animate elements on load
            const elements = document.querySelectorAll('.weather-display > *, .detail-card');
            elements.forEach((element, index) => {
                element.classList.add('animate');
                element.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Create rain animation if needed
            if(document.body.classList.contains('rain')) {
                createRainDrops();
            }
            
            // Create snow animation if needed
            if(document.body.classList.contains('snow')) {
                createSnowflakes();
            }
            
            // Refresh button functionality
            document.getElementById('refreshBtn').addEventListener('click', function() {
                this.classList.add('rotating');
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            });
        });
        
        function createRainDrops() {
            const weatherBg = document.querySelector('.weather-bg');
            for(let i = 0; i < 50; i++) {
                const drop = document.createElement('div');
                drop.classList.add('rain-drop');
                drop.style.left = `${Math.random() * 100}%`;
                drop.style.animationDuration = `${0.5 + Math.random() * 0.5}s`;
                drop.style.animationDelay = `${Math.random() * 2}s`;
                drop.style.animationName = 'rainFall';
                drop.style.animationIterationCount = 'infinite';
                weatherBg.appendChild(drop);
            }
            
            // Add the rain animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes rainFall {
                    0% { transform: translateY(-100px); opacity: 0; }
                    10% { opacity: 0.6; }
                    90% { opacity: 0.6; }
                    100% { transform: translateY(100vh); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
        }
        
        function createSnowflakes() {
            const weatherBg = document.querySelector('.weather-bg');
            for(let i = 0; i < 30; i++) {
                const flake = document.createElement('div');
                flake.classList.add('snowflake');
                flake.innerHTML = '❄';
                flake.style.left = `${Math.random() * 100}%`;
                flake.style.animationDuration = `${5 + Math.random() * 10}s`;
                flake.style.animationDelay = `${Math.random() * 5}s`;
                flake.style.animationName = 'snowFall';
                flake.style.animationIterationCount = 'infinite';
                weatherBg.appendChild(flake);
            }
            
            // Add the snow animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes snowFall {
                    0% { transform: translateY(-100px) rotate(0deg); opacity: 0; }
                    10% { opacity: 0.8; }
                    90% { opacity: 0.8; }
                    100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
        }
    </script>
</body>
</html>