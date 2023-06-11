
const locationInput = document.querySelector('#locationInput');
const searchInput = document.querySelector('.search');
const citiesList = document.querySelector('.cities');

const apiKey = '4e89a6f7472cafefcee320e3820edfb5';

async function getWeatherData(city) {
  const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${apiKey}`;
  const response = await fetch(url);
  const data = await response.json();
  return data;
}

// Update UI with weather data
function updateUI(data) {
  const temp = Math.round(data.main.temp);
  const cityName = data.name;
  const condition = data.weather[0].main;
  const iconCode = data.weather[0].icon;

  const cityElement = document.querySelector('.name');
  const tempElement = document.querySelector('.temp');
  const conditionElement = document.querySelector('.condition');
  const iconElement = document.querySelector('.icon');

  cityElement.textContent = cityName;
  tempElement.innerHTML = `${temp}&#176;`;
  conditionElement.textContent = condition;
  iconElement.src = `http://openweathermap.org/img/wn/${iconCode}.png`;
  document.body.style.backgroundImage = `url('https://source.unsplash.com/1600x900/?${cityName}')`;
}

// Update UI with weather details
async function updateWeatherDetails(city) {
  const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${apiKey}`;
  const response = await fetch(url);
  const data = await response.json();

  const cloudiness = data.clouds.all;
  const humidity = data.main.humidity;
  const windSpeed = data.wind.speed;
  const pressure = data.main.pressure;
  const rainfall = data.rain ? data.rain['1h'] : 0;

  const cloudinessElement = document.querySelector('.cloud');
  const humidityElement = document.querySelector('.humidity');
  const windElement = document.querySelector('.wind');
  const pressureElement = document.querySelector('.pressure');
  const rainfallElement = document.querySelector('.rainfall');

  cloudinessElement.textContent = `${cloudiness}%`;
  humidityElement.textContent = `${humidity}%`;
  windElement.textContent = `${windSpeed}km/hr`;
  pressureElement.textContent = `${pressure}mbar`;
  rainfallElement.textContent = `${rainfall}mm`;
}

function updateLocalTime() {
  const now = new Date();
  const localTimeElement = document.querySelector('.local-time');
  localTimeElement.textContent = now.toLocaleTimeString();
}

setInterval(updateLocalTime, 1000);
const options = {
  weekday: 'long',
  year: 'numeric',
  month: '2-digit',
  day: '2-digit',
  hour: '2-digit',
  minute: '2-digit',
  second: '2-digit',
  hour12: true
};

function updateLocalTime() {
  const now = new Date();
  const localTimeElement = document.querySelector('.local-time');
  localTimeElement.textContent = now.toLocaleString(undefined, options);
}

setInterval(updateLocalTime, 1000);

locationInput.addEventListener('submit', (e) => {
  e.preventDefault();
  const city = searchInput.value.trim();
  if (city === '') {
    return;
  }

  getWeatherData(city)
    .then((data) => {
      updateUI(data);
      updateWeatherDetails(city);
    })
    .catch((err) => {
      console.log(err);
      alert('City not found. Please enter a valid city name.');
    });

  searchInput.value = '';
});

// Event listener for city selection
citiesList.addEventListener('click', (e) => {
  const city = e.target.textContent.trim();
  getWeatherData(city)
    .then((data) => {
      updateUI(data);
      updateWeatherDetails(city);
    })
    .catch((err) => {
      console.log(err);
    });
});

//new codes
const previousButton = document.querySelector('#previousButton');

previousButton.addEventListener('click', () => {
  window.location.href = 'http://localhost/prototype2/shrisha2332330.php';
});
