
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Budget Buddy</title>
    <link rel="icon" href="./budget.png" type="image/png" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
      integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

  </head>
  <body>
    <?php 
    session_start();
    $response = []; 
    ?>
    <section class="section">
      <!-- two columns -->
      <div class="columns">
        <!-- COL 1 -->
        <div class="column">
          <h1 class="title is-1">Budget Buddy</h1>
          <p class="subtitle">
            <span>Welcome to <strong>Budget Buddy</strong> official site!</span><br>
          </p>
          <p class="subtitle">Please login to download your expenses report</p>
          <br>
          <?php if (!array_key_exists("user",$response)) {
              require "login-form.php";
          } ?>

          <?php 
          
          if (isset($_POST["email"]) && isset($_POST["password"])) {
              //retrieve the values from html form
              $email = $_POST["email"];
              $password = $_POST["password"];

              // connecting to db
              require_once __DIR__ . "/api/v1/dbConnect.php";
              $db = new DB_CONNECT();
              $db->connect();
              $sqlCommand = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
              $result = mysqli_query($db->myconn, "$sqlCommand");

              // check the result
              if (mysqli_num_rows($result) > 0) {
                  $row = mysqli_fetch_assoc($result);
                  $user = [
                      "userId" => (int) $row["userId"],
                      "name" => $row["name"],
                      "email" => $row["email"],
                      "password" => $row["password"],
                      "createdOn" => $row["createdOn"],
                  ];
                  $response["user"] = $user;
                  $_SESSION["userId"] =(int)$row["userId"];
                  $_SESSION["name"] =$row["name"];

                  echo "<p class='subtitle'> Hi <strong>" .
                      $row["name"] .
                      "</strong>, your report is ready for download<p><br>";
                  echo "<button class='button is-danger'>Download</button>";
                  header("location: report.php");
              } else {
                  // Handling error response
                  echo "<br><p class='subtitle'> Login request failed<p>";
              }
              $db->close($db->myconn);
          } ?>
        </div>
        <!-- COL 2 -->
        <div class="column">
          <div class="is-max-desktop">
            <img
              src="https://img.freepik.com/free-vector/online-payment-account-credit-card-details-personal-information-financial-transaction-cartoon-character-bank-worker-internet-banking_335657-2379.jpg?w=2000">
          </div>
        </div>
      </div>
    </section>

  </body>

</html>

