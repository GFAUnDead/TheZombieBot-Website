<html>
  <head>
    <title>YourBotsOnline API</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="https://lscdn.site/static/logos/lochstudios/LSLarge.png" type="image/png" />
  </head>
  <body>
    <div class="container">
      <h1>YourBotsOnline API</h1>
      <p>This website is currently holding the following APIs:</p>
      <ul>
        <li class="api" data-name="Time">Time</li>
        <li class="api" data-name="Weather">Weather</li>
        <li class="api" data-name="Todo list">Todo list</li>
      </ul>
      <div class="api-info"></div>
    </div>

    <script>
      const apis = document.querySelectorAll('.api');

      for (let api of apis) {
        api.addEventListener('click', function() {
          const apiName = this.getAttribute('data-name');
          const apiInfo = getApiInfo(apiName);
          showApiInfo(apiInfo);
        });
      }

      function getApiInfo(apiName) {
        // This function should return the information about the given API name
        switch (apiName) {
          case 'Time':
            return 'This API provides the current time in various timezones.';
          case 'Weather':
            return 'This API provides the current weather conditions for a given location.';
          case 'Todo list':
            return 'This API allows users to create and manage todo lists.';
          default:
            return '';
        }
      }

      function showApiInfo(apiInfo) {
        const apiInfoDiv = document.querySelector('.api-info');
        apiInfoDiv.textContent = apiInfo;
      }
    </script>
  </body>
</html>