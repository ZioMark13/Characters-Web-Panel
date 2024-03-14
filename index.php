  <!-- Developed by ZIOMARK for the Community -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VORP | Character List</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
  <div class="container">
    <h2>VORP | Character List</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Steam Name</th>
          <th>Character Identifier</th>
          <th>Discord ID</th>
          <th>Group</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        function loadEnv($path) {
          if (!file_exists($path)) {
              throw new Exception("Il file .env non è stato trovato in: {$path}");
          }
      
          $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
          foreach ($lines as $line) {
              if (strpos(trim($line), '#') === 0) {
                  continue;
              }
      
              list($name, $value) = explode('=', $line, 2);
              $name = trim($name);
              $value = trim($value);
      
              if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                  putenv(sprintf('%s=%s', $name, $value));
                  $_ENV[$name] = $value;
                  $_SERVER[$name] = $value;
              }
          }
      }
      
      loadEnv(__DIR__ . '/.env');
      
      $servername = getenv('DB_SERVER');
      $username = getenv('DB_USERNAME');
      $password = getenv('DB_PASSWORD');
      $dbname = getenv('DB_NAME');

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
          die("Connessione fallita: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM characters";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['steamname'] . "</td>";
            echo "<td>" . $row['charidentifier'] . "</td>";
            echo "<td>" . $row['discordid'] . "</td>";
            echo "<td>" . $row['group'] . "</td>";
            echo "<td><button type='button' class='btn btn-info' data-toggle='modal' data-target='#infoModal" . $row['charidentifier'] . "'>Info</button></td>";
            echo "</tr>";
            echo "<div class='modal fade' id='infoModal" . $row['charidentifier'] . "' tabindex='-1' role='dialog' aria-labelledby='infoModalLabel" . $row['charidentifier'] . "' aria-hidden='true'>";
            echo "<div class='modal-dialog' role='document'>";
            echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
            echo "<h5 class='modal-title' id='infoModalLabel" . $row['charidentifier'] . "'><i class='fas fa-user'></i> " . $row['firstname'] . " " . $row['lastname'] . " aka <u>" . $row['nickname'] . "</u></h5>";
            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
            echo "<span aria-hidden='true'>&times;</span>";
            echo "</button>";
            echo "</div>";
            echo "<div class='modal-body'>";
            echo "<p><i class='fas fa-money-bill-alt'></i> Money: " . $row['money'] . "</p>";
            echo "<p><i class='fas fa-coins'></i> Gold: " . $row['gold'] . "</p>";
            echo "<p><i class='fas fa-briefcase'></i> Job: " . $row['job'] . "</p>";
            echo "<p><i class='fas fa-chart-line'></i> Job Grade: " . $row['jobgrade'] . "</p>";
            echo "<p><i class='fas fa-birthday-cake'></i> Age: " . $row['age'] . "</p>";
            echo "<p><i class='fas fa-venus-mars'></i> Gender: " . $row['gender'] . "</p>";
            echo "<p>Health: <progress max='100' value='" . $row['healthinner'] . "'></progress> " . $row['healthinner'] . "/100</p>";
            echo "<p>Stamina: <progress max='100' value='" . $row['staminainner'] . "'></progress> " . $row['staminainner'] . "/100</p>";
            echo "</div>";
            echo "<div class='modal-footer'>";
            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<tr><td colspan='5'>Nessun dato trovato</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Developed by ZIOMARK for the Community -->
</body>
</html>
