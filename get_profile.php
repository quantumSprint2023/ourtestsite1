<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ваш сайт - Обзор</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@700&display=swap">
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      margin: 0;
      display: flex;
      align-items: stretch;
      justify-content: stretch;
      height: 100vh;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    body.loaded {
      opacity: 1;
    }

    body.light-mode {
      background-color: #f8f9fa;
      color: #333333;
    }

    body.dark-mode {
      background-color: #121212;
      color: #ffffff;
    }

    body.quantum-mode {
      background-color: #F5F5F5;
      color: #333333;
    }

    #container {
      display: flex;
      width: 100%;
      height: 100%;
      animation: slideIn 1s ease-in-out;
    }

    @keyframes slideIn {
      from {
        transform: translateX(-50px);
      }
      to {
        transform: translateX(0);
      }
    }

    #sidebar {
      width: 200px;
      color: #ffffff;
      padding-top: 20px;
      transition: width 0.5s;
      overflow-y: auto;
      border-radius: 0 15px 15px 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      animation: fadeIn 1s ease-in-out;
      box-shadow: 2px 2px 10px #001F3F;
    }

    body.dark-mode #sidebar {
      background: linear-gradient(180deg, #121212 0%, #000000 100%);
      color: #ffffff;
    }

    body.quantum-mode #sidebar {
      background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);
      color: #ffffff;
    }

    #sidebar:hover {
      width: 250px;
      box-shadow: 5px 5px 15px #001F3F;
    }

    .sidebar-item {
      padding: 12px 15px;
      text-decoration: none;
      font-size: 16px;
      font-weight: bold;
      display: block;
      transition: background-color 0.3s;
      margin-bottom: 5px;
      border-right: 5px solid transparent;
    }

    body.dark-mode .sidebar-item:hover {
      background-color: #00456B;
      border-right-color: #ffffff;
    }

    body.quantum-mode .sidebar-item:hover {
      background-color: #CCCCCC;
      border-right-color: #00A8E8;
    }

    #content {
      flex: 1;
      padding: 16px;
      position: relative;
      animation: fadeIn 1s ease-in-out;
    }

    body.dark-mode #content {
      background-color: #121212;
      color: #ffffff;
    }

    body.quantum-mode #content {
      background-color: #F5F5F5;
      color: #333333;
    }

    .profile-tile {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      border: 2px solid #0077B5;
      animation: fadeIn 1s ease-in-out;
    }

    body.dark-mode .profile-tile {
      background-color: #121212;
      color: #ffffff;
    }

    body.quantum-mode .profile-tile {
      background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);
      color: #ffffff;
    }

    h2 {
      color: #0077B5;
      border-bottom: 2px solid #0077B5;
      padding-bottom: 8px;
    }

    .profile-info {
      margin-top: 10px;
    }

    #support-button {
      position: fixed;
      top: 10px;
      right: 10px;
      color: #ffffff;
      padding: 14px 20px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s, transform 0.3s ease-in-out;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #support-button:hover {
      transform: scale(1.05);
    }

    body.dark-mode #support-button {
      background-color: #0077B5;
    }

    body.quantum-mode #support-button {
      background-color: #00A8E8;
    }

    #language-select-container,
    #theme-select-container {
      margin-top: 10px;
      margin-bottom: 10px;
      text-align: center;
    }

    #language-select,
    #theme-select {
      padding: 8px;
      font-size: 14px;
    }

    .profile-tile.updated {
      border-color: #4CAF50;
      transition: border-color 0.5s ease-in-out;
    }
  </style>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.body.classList.add("loaded");
    });

    function toggleDarkMode() {
      document.body.classList.toggle('dark-mode');
    }

    function toggleQuantumMode() {
      document.body.classList.toggle('quantum-mode');
    }

    function changeTheme() {
      var themeSelect = document.getElementById('theme-select');
      var selectedTheme = themeSelect.value;

      if (selectedTheme === 'dark') {
        toggleDarkMode();
      } else if (selectedTheme === 'quantum') {
        toggleQuantumMode();
      } else {
        document.body.classList.remove('dark-mode', 'quantum-mode');
        document.getElementById('sidebar').classList.remove('quantum-mode');
        document.getElementById('content').classList.remove('quantum-mode');
        document.querySelector('.profile-tile').classList.remove('quantum-mode', 'updated');
        document.getElementById('support-button').classList.remove('quantum-mode');
        var sidebarItems = document.querySelectorAll('.sidebar-item');
        sidebarItems.forEach(function (item) {
          item.classList.remove('quantum-mode');
        });
      }
    }

    function getProfileInformation() {
      var contractNumber = document.getElementById('inputContractNumber').value;
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'get_profile.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
          if (xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.error) {
              alert(response.error);
            } else {
              updateProfileInformation(response);
            }
          } else {
            alert('Произошла ошибка при выполнении запроса');
          }
        }
      };
      xhr.send('contractNumber=' + encodeURIComponent(contractNumber));
    }

    function updateProfileInformation(data) {
      document.getElementById('profileFirstName').innerText = data.first_name;
      document.getElementById('profileLastName').innerText = data.last_name;
      document.getElementById('profilePosition').innerText = data.position;

      document.querySelector('.profile-tile').classList.add('updated');

      setTimeout(function () {
        document.querySelector('.profile-tile').classList.remove('updated');
      }, 2000);
    }
  </script>
</head>
<body>
  <!-- ... -->

  <div id="container">
    <div id="sidebar">
      <div id="theme-select-container">
        <label for="theme-select">Theme:</label>
        <select id="theme-select" onchange="changeTheme()">
          <option value="light">Light</option>
          <option value="dark">Dark</option>
          <option value="quantum">Quantum</option>
        </select>
      </div>

      <a id="overview-link" href="#overview" class="sidebar-item">Обзор</a>
      <a id="my-balance-link" href="#my-balance" class="sidebar-item">Мой баланс</a>
      <a id="my-team-link" href="#my-team" class="sidebar-item">Моя команда</a>
      <hr>
      <a id="copytrading-link" href="#copytrading" class="sidebar-item">Копитрейдинг</a>
      <a id="strategy-link" href="#strategy" class="sidebar-item">Стратегия</a>
      <a id="my-accounts-link" href="#my-accounts" class="sidebar-item">Мои аккаунты</a>
      <hr>
      <a id="settings-link" href="#settings" class="sidebar-item">Настройки</a>
      <a id="logout-link" href="#logout" class="sidebar-item">Выход с аккаунта</a>
    </div>
    
    <div id="content">
      <h2>Обзор</h2>
      <form id="profileForm">
        <div class="form-group">
          <label id="contractNumberLabel" for="inputContractNumber">Контрактный номер:</label>
          <input type="text" id="inputContractNumber" name="contractNumber" placeholder="Введите контрактный номер" required>
        </div>
        <button type="button" id="getInfoButton" onclick="getProfileInformation()">Получить информацию</button>
      </form>
      <div class="profile-tile">
        <h2 id="profile-title">Профиль</h2>
        <div class="profile-info">
          <p id="firstName-label">Имя: <span id="profileFirstName"></span></p>
          <p id="lastName-label">Фамилия: <span id="profileLastName"></span></p>
          <p id="position-label">Должность: <span id="profilePosition"></span></p>
        </div>
      </div>
    </div>
  </div>

  <button id="support-button" onclick="window.open('https://t.me/Previuyshni', '_blank')">Поддержка</button>

</body>
</html>
