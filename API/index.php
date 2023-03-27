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
      <div class="api-buttons">
        <button class="api" data-name="Time">Time</button>
        <button class="api" data-name="Weather">Weather</button>
        <button class="api" data-name="Todo list">Todo list</button>
      </div>
      <div class="api-info"></div>
    </div>

    <?php
      // Define an array with the API information
      $apiInfo = array(
        'Time' => 'This API provides the current time in various timezones.',
        'Weather' => 'This API provides the current weather conditions for a given location.',
        'Todo list' => 'This API allows users to create and manage todo lists.'
      );
    ?>

    <script>
      const apis = document.querySelectorAll('.api');

      for (let api of apis) {
        api.addEventListener('click', function() {
          const apiName = this.getAttribute('data-name');
          const apiInfo = '<?php echo $apiInfo[' + apiName + ']; ?>';
          showApiInfo(apiInfo);
        });
      }

      function showApiInfo(apiInfo) {
        const apiInfoDiv = document.querySelector('.api-info');
        apiInfoDiv.textContent = apiInfo;
      }
    </script>
  </body>
</html>
