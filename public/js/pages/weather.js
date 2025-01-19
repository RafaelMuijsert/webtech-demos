async function getWeather() {
    const cityInput = document.getElementById('city-input');
    const resultDiv = document.getElementById('weather-result');
    const city = cityInput.value.trim();
    
    if (!city) {
        resultDiv.innerHTML = '<p class="error">Please enter a city name</p>';
        return;
    }
    
    try {
        const response = await fetch(`/api/fetch_weather.php?city=${encodeURIComponent(city)}`);
        const data = await response.json();
        
        if (data.error) {
            resultDiv.innerHTML = `<p class="error">${data.error}</p>`;
            return;
        }
        
        resultDiv.innerHTML = `
            <div class="weather-info">
                <h2>${data.name}, ${data.sys.country}</h2>
                <p class="temperature">${Math.round(data.main.temp)}°C</p>
                <p class="description">${data.weather[0].description}</p>
                <p>Humidity: ${data.main.humidity}%</p>
                <p>Wind Speed: ${data.wind.speed} m/s</p>
            </div>
        `;
    } catch (error) {
        resultDiv.innerHTML = '<p class="error">Failed to fetch weather data</p>';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const cityInput = document.getElementById('city-input');
    cityInput.addEventListener('keypress', (event) => {
        if (event.key === 'Enter') {
            getWeather();
        }
    });
});
