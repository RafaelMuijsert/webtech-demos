async function getWeather() {
  const selector = document.getElementById("country-selector");
  const resultDiv = document.getElementById("weather-result");
  const location = selector.value.trim();

  if (!location) {
    resultDiv.innerHTML = '<p class="error">Please select a location</p>';
    return;
  }

  try {
    const response = await fetch(
      `/api/weather.php?location=${encodeURIComponent(location)}`,
    );
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
