<?php

// Avvia una sessione

session_start();

// Carica il file di connessione al database

$mysqli = require __DIR__ . "./assets/db/database.php";

    // Acquisisco nome e email dell'utente loggato
  
    $sql_user = "SELECT nome, cognome, email, is_admin FROM utenti WHERE id = {$_SESSION["user_id"]}";

    
    $result = $mysqli->query($sql_user);

    $user = $result->fetch_assoc();

    // Se l'utente non è un amministratore, lo reindirizzo alla pagina degli eventi

    if(!$user['is_admin']) {
     header("Location:user-events.php");
    }

    // Acquisisco tutti gli utenti registrati

    $sql_users = "SELECT id, email FROM utenti";

    $result_users = $mysqli->query($sql_users);

    $users = [];

    while ($result = $result_users->fetch_assoc()) {

      $users[] = $result;
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstap -->

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
      crossorigin="anonymous"
    />

    <!-- Styles -->
    <link rel="stylesheet" href="assets\styles\style.css" />
    <link rel="stylesheet" href="assets\styles\dashboard.css">
    <link rel="stylesheet" href="assets\styles\events.css">


    <!-- JS script -->
    <script src="js/deleteEvent.js"></script>

    <title>Edusogno - Dashboard</title>
  </head>

  <body>
    <!-- Sezione Header del sito -->

    <header class="d-flex">
      <!-- Logo -->
      <div id="logo">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="124"
          height="53"
          viewBox="0 0 124 53"
          fill="none"
        >
          <path
            d="M63.8577 17.1194V19.0764H50.945C51.4423 18.6273 51.6909 17.9536 51.6909 16.6703V3.30044C51.6909 2.02521 51.4423 1.35151 50.945 0.894348H63.585V2.87537C63.1359 2.40217 62.5584 2.1776 61.2591 2.1776H57.0404V8.4976H59.9598C60.7665 8.5749 61.5743 8.36158 62.2376 7.89608V10.3503C61.5743 9.8848 60.7665 9.67148 59.9598 9.74878H57.0404V17.8172H61.5158C62.783 17.8172 63.3845 17.5926 63.8337 17.1194H63.8577Z"
            fill="#2D224C"
          />
          <path
            d="M74.2841 19.0764L74.0836 16.927C73.6559 17.6722 73.0299 18.2841 72.2752 18.6948C71.5205 19.1054 70.6667 19.2986 69.8087 19.2529C67.1059 19.2529 64.9324 17.1756 64.9324 12.6522C64.9324 8.1287 67.4828 6.0354 70.0092 6.0354C70.8334 6.02315 71.6458 6.23163 72.3622 6.63919C73.0786 7.04676 73.673 7.63858 74.0836 8.35326V3.17214C74.1617 2.37543 73.9479 1.57745 73.482 0.926461C74.6771 0.854278 77.6045 0.653768 79.377 0.429199V16.8227C79.3126 17.6255 79.5374 18.4248 80.0106 19.0764H74.2841ZM74.0836 15.3791V9.92525C73.9664 9.56711 73.7387 9.25536 73.4332 9.03485C73.1277 8.81434 72.76 8.69645 72.3832 8.69814C71.2043 8.69814 70.6108 9.54829 70.5867 12.7083C70.5626 15.8683 71.2043 16.7185 72.3832 16.7185C72.7723 16.714 73.1492 16.5821 73.4563 16.3432C73.7634 16.1042 73.9837 15.7712 74.0836 15.3951V15.3791Z"
            fill="#2D224C"
          />
          <path
            d="M90.1002 19.0764L89.9719 16.927C89.5894 17.6716 88.9978 18.2883 88.2698 18.7015C87.5418 19.1147 86.7089 19.3063 85.8735 19.2529C83.0504 19.2529 81.8634 17.6488 81.8634 14.6572V8.52168C81.9101 8.19606 81.8801 7.86401 81.7757 7.55207C81.6712 7.24013 81.4953 6.95694 81.2618 6.72513C83.0825 6.64493 85.2078 6.42036 87.1568 6.22787V14.8176C87.1568 15.8202 87.4054 16.6463 88.432 16.6463C88.709 16.6374 88.9774 16.5476 89.2041 16.388C89.4307 16.2283 89.6056 16.0059 89.7072 15.748V8.5297C89.754 8.20408 89.724 7.87204 89.6195 7.56009C89.5151 7.24815 89.3391 6.96496 89.1057 6.73315C90.9343 6.65295 93.0597 6.42838 95.0087 6.23589V16.8227C94.9331 17.6256 95.1433 18.4293 95.6022 19.0925L90.1002 19.0764Z"
            fill="#2D224C"
          />
          <path
            d="M61.5639 22.9983L60.9864 24.4981C60.0693 23.7819 58.9419 23.3873 57.7783 23.3753C56.3025 23.3753 55.6288 23.7522 55.6288 24.6264C55.6288 26.2947 62.2055 26.9684 62.2055 30.9224C62.2055 33.922 59.5748 35.2935 55.3802 35.2935C53.6848 35.3896 51.9941 35.0354 50.4798 34.2669L51.0332 32.7911C52.0902 33.5475 53.3586 33.9516 54.6584 33.9461C56.2624 33.9461 56.9763 33.4969 56.9763 32.5425C56.9763 30.3209 50.56 30.6738 50.4798 26.3749C50.4798 23.9688 52.3565 22.0519 57.1768 22.0519C58.6937 22.0133 60.1978 22.3377 61.5639 22.9983Z"
            fill="#2D224C"
          />
          <path
            d="M77.6046 28.7008C77.6046 32.2779 74.9338 35.3256 70.3863 35.3256C65.5741 35.3256 63.168 32.5024 63.168 28.7008C63.168 25.1318 65.8709 22.084 70.3863 22.084C75.1343 22.052 77.6046 24.8751 77.6046 28.7008ZM68.7823 28.7008C68.7823 33.3285 69.2073 34.315 70.3863 34.315C71.5653 34.315 71.9904 33.3446 71.9904 28.7008C71.9904 24.057 71.5894 23.1347 70.3863 23.1347C69.1833 23.1347 68.7823 24.049 68.7823 28.7008Z"
            fill="#2D224C"
          />
          <path
            d="M100.92 35.1171H107.44C106.974 34.4568 106.761 33.6515 106.839 32.8473V27.2331C106.839 24.2094 105.82 22.0359 102.467 22.0359C101.683 22.0035 100.905 22.1867 100.218 22.5657C99.5307 22.9447 98.9606 23.5049 98.5696 24.1854V22.2204C97.1179 22.4049 95.0727 22.7497 93.6772 22.9583C91.8459 23.2018 89.9964 23.2796 88.1512 23.1909C87.0748 22.5233 85.8123 22.2196 84.5501 22.3247C81.1815 22.3247 78.9358 24.3458 78.9358 26.8241C78.9391 27.5649 79.14 28.2915 79.5178 28.9288C79.8957 29.5661 80.4368 30.0909 81.0853 30.4492C80.5392 30.7652 80.0913 31.2262 79.7912 31.7811C79.4911 32.3361 79.3505 32.9633 79.385 33.5932C79.3739 34.0081 79.4455 34.421 79.5956 34.8079C79.7457 35.1948 79.9712 35.548 80.2592 35.8469C79.8582 35.9849 79.5092 36.2428 79.2596 36.5856C79.01 36.9285 78.8718 37.3398 78.8636 37.7638C78.8636 39.3678 81.6066 40.1699 84.7826 40.1699C88.5602 40.1699 91.4796 38.7182 91.4796 36.1597C91.4796 33.906 89.6028 32.5345 84.8067 32.4623L82.4006 32.4142C81.6547 32.4142 81.4221 32.0854 81.4221 31.7325C81.442 31.554 81.511 31.3845 81.6214 31.2429C81.7319 31.1013 81.8794 30.9932 82.0477 30.9305C82.8714 31.1968 83.7325 31.3294 84.5982 31.3234C88.0229 31.3234 90.2685 29.3023 90.2685 26.8561C90.3059 25.7871 89.9196 24.7466 89.1938 23.9608L93.4927 24.1693C93.5484 24.433 93.5753 24.7019 93.5729 24.9714V32.8714C93.6504 33.6756 93.437 34.4809 92.9714 35.1411H99.4678C99.0022 34.4809 98.7888 33.6756 98.8663 32.8714V25.3483C99.0218 25.1195 99.2372 24.9378 99.489 24.8233C99.7408 24.7087 100.019 24.6656 100.294 24.6987C101.321 24.6987 101.569 25.5007 101.569 26.4952V32.8473C101.633 33.6574 101.402 34.4633 100.92 35.1171ZM81.4783 36.3923L86.2905 36.6169C87.8945 36.689 88.5121 36.9938 88.5121 37.5713C88.5121 38.1487 87.67 39.1753 84.7666 39.1753C83.347 39.1753 81.3179 38.6219 81.3179 37.4029C81.2983 37.0584 81.353 36.7137 81.4783 36.3923ZM84.5501 30.3931C83.6518 30.3931 83.2989 29.7435 83.331 26.8241C83.363 23.9047 83.6518 23.2229 84.5501 23.2229C85.4483 23.2229 85.8012 23.8485 85.8012 26.8241C85.8012 29.7996 85.5045 30.3931 84.5501 30.3931Z"
            fill="#2D224C"
          />
          <path
            d="M123.136 28.7008C123.136 32.2779 120.457 35.3256 115.918 35.3256C111.105 35.3256 108.699 32.5024 108.699 28.7008C108.699 25.1318 111.394 22.084 115.918 22.084C120.658 22.052 123.136 24.8751 123.136 28.7008ZM114.314 28.7008C114.314 33.3285 114.739 34.315 115.918 34.315C117.097 34.315 117.522 33.3446 117.522 28.7008C117.522 24.057 117.121 23.1347 115.918 23.1347C114.715 23.1347 114.338 24.049 114.314 28.7008Z"
            fill="#2D224C"
          />
          <path
            d="M0 0.9104H45.0581V1.56005C45.0581 8.68209 45.1303 15.7961 45.0581 22.9101C44.9058 34.9406 39.5081 43.763 28.9614 49.5296C27.1006 50.5401 25.2159 51.4945 23.3471 52.4891C23.1033 52.6298 22.8267 52.704 22.5451 52.704C22.2635 52.704 21.9869 52.6298 21.7431 52.4891C19.6017 51.3502 17.4281 50.2754 15.3268 49.0884C11.443 47.0159 8.08655 44.0799 5.51561 40.5065C2.94468 36.933 1.22785 32.8174 0.49726 28.4762C0.191221 26.7447 0.0409062 24.9893 0.0481215 23.2309C-4.27255e-07 16.0127 0.0481215 8.79437 0.0481215 1.57609L0 0.9104ZM2.34995 3.23629V3.76564C2.34995 10.2541 2.34995 16.7425 2.34995 23.2309C2.35348 24.6135 2.45802 25.994 2.66274 27.3614C3.18763 31.1777 4.54803 34.8311 6.64694 38.0613C8.74585 41.2915 11.5316 44.0188 14.8055 46.0487C17.2116 47.5806 19.7701 48.7756 22.2724 50.107C22.365 50.1465 22.4645 50.1669 22.5652 50.1669C22.6658 50.1669 22.7654 50.1465 22.8579 50.107C24.0128 49.5215 25.1357 48.8879 26.2986 48.3105C29.75 46.7211 32.871 44.4953 35.4979 41.7498C40.064 36.9185 42.629 30.536 42.6761 23.8886C42.7723 17.1836 42.6761 10.4786 42.6761 3.77365C42.6761 3.60523 42.6761 3.42878 42.6761 3.23629H2.34995Z"
            fill="#2D224C"
          />
          <path
            d="M25.5688 15.5234H18.4387V33.4488H25.5688V15.5234Z"
            fill="#2D224C"
          />
          <path
            d="M18.3242 22.1327L13.4602 20.395L9.38032 31.8148L14.2443 33.5525L18.3242 22.1327Z"
            fill="#2D224C"
          />
          <path
            d="M27.8165 11.5998L24.6555 12.764L32.2426 33.3628L35.4035 32.1986L27.8165 11.5998Z"
            fill="#2D224C"
          />
        </svg>
      </div>
      <!-- Menu navigazione -->
      <div class="menu">
        <a href="user-events.php">My events</a>
        <a href="logout.php">Log out</a>
      </div>
    </header>

    <!-- Sezione main -->

    <main>
      <div class="container">
        <div class="d-flex flex-row justify-content-between">
          <!-- Cerchio sinistro -->

          <div class="ellipse large"></div>

          <!-- Eventi utenti -->

          <div class="center">
           <div class="description">
            <h2 class="question text-center">Ciao <?= htmlspecialchars($user["nome"]) ?>  <?= htmlspecialchars($user["cognome"]) ?></h2>
            <span>Da questa pagina puoi vedere gli eventi di tutti gli utenti, </span>
            <br>
            <span>inoltre puoi <a href="create-event.php">creare nuovi eventi</a> e modificare o eliminare quelli esistenti. </span>
            <br>

           </div>
           <!-- Permette di selezionare l'utente di cui si vogliono vedere gli eventi -->

           <form method="post" onchange="event.preventDefault()" class="email-list">
            <label for="user">Seleziona un utente</label>
             <select name="users">
               <option value="-1">Seleziona email</option>
              <?php foreach ($users as $user) { ?>

               <option value="<?php echo $user['id'];?>"><?php echo "{$user['email']}";?></option>
              
              <?php } ?>
             </select>
             <br>
              <input class="btn btn-primary button search-button" type="submit" style="width:400px" value="CERCA" />
             
            </form>
            <div class="events d-flex">
              
            <?php 
             if(isset($_POST['users'])) {

              $sql_selected_user = "SELECT nome, cognome, email FROM utenti WHERE id = {$_POST['users']}";

    
              $result = $mysqli->query($sql_selected_user);

              $user = $result->fetch_assoc();

              // Acquisisco gli eventi dell'utente

               $sql_events = "SELECT * FROM eventi WHERE attendees LIKE '%" . $user['email'] . "%'";

               $result_events = $mysqli->query($sql_events);

               $events = [];

               while ($result = $result_events->fetch_assoc()) {

                 $events[] = $result;
               }
              }

              // Mostra tutti gli eventi dell'utente selezionato

              foreach ($events as $value) { ?>
                <div class= "event">
                    
                    <h2><?php echo "{$value["nome_evento"]}";?></h2>

                    <h5>Partecipanti:</h5>

                    <?php
                     $attendees = explode(",", $value["attendees"]);
                     foreach ($attendees as $attendee) { ?>
                     <p><?php echo "{$attendee}";?></p>

                     <?php } ?>
                    <span class="time"><?php echo "{$value["data_evento"]}";?></span>
                    <br>
                    <div class="d-flex justify-content-between mt-3">

                      <!-- Modifica e eliminazione dell'evento -->
                      
                      <div class="delete-event">
                        <form action="delete-event.php" method="post">
                          <input type="hidden" name="id" value="<?php echo "{$value["id"]}"; ?>">
                          <input class="btn btn-danger" type="submit" value="DELETE" onclick="return confirm('Sei sicuro di voler eliminare questo evento?')"/>
                        </form>
                      </div>
                      <div class="edit-event">
                        <form action="edit-event.php" method="post">
                          <input type="hidden" name="id" value="<?php echo "{$value["id"]}"; ?>">
                          <input class="btn btn-primary" type="submit" value="EDIT"/>
                        </form>
                      </div>
                    </div>
                </div>
              <?php } ?>
            </div>
          </div>

          <!-- Cerchio destro -->

          <div class="ellipse small"></div>
        </div>
      </div>
    </main>

    <!-- Sezione footer -->

    <footer>
      <div class="wave-box">
        <svg
          class="wave"
          xmlns="http://www.w3.org/2000/svg"
          height="128"
          viewBox="0 0 1440 128"
          fill="none"
        >
          <path
            d="M550.04 20.7802C309.334 -30.4323 58.3859 24.9498 -37 59.0424V152L1505.7 142.434C1506.68 130.171 1508.06 94.1161 1505.7 48.0053C1428.64 75.2303 850.923 84.7959 550.04 20.7802Z"
            fill="white"
          />
        </svg>
        <svg
          class="wave"
          xmlns="http://www.w3.org/2000/svg"
          height="333"
          viewBox="0 0 1440 333"
          fill="none"
        >
          <path
            d="M488.772 199.429C281.838 125.104 291.158 -34.8781 -52.8359 7.2956L-120.693 422.193L1422.4 630.732C1432.33 576.156 1460.02 415.457 1491.34 209.267C1394.73 318.23 695.707 273.754 488.772 199.429Z"
            fill="#CBDAEC"
          />
        </svg>
        <svg
          class="wave"
          xmlns="http://www.w3.org/2000/svg"
          height="226"
          viewBox="0 0 1440 226"
          fill="none"
        >
          <path
            d="M1333.21 30.8969C1794.82 -45.248 2276.07 37.0965 2459 87.7868V226L-499.505 211.778C-501.388 193.544 -504.023 139.936 -499.505 71.3763C-351.721 111.856 756.189 126.078 1333.21 30.8969Z"
            fill="#B8CCE4"
          />
        </svg>

        <svg
          class="rocket"
          xmlns="http://www.w3.org/2000/svg"
          width="111"
          height="185"
          viewBox="0 0 111 185"
          fill="none"
        >
          <path d="M55.5 0L87.1099 63H23.8901L55.5 0Z" fill="white" />
          <rect x="24" y="63" width="63" height="96" fill="white" />
          <path d="M0 145.867L20 127V159.145L0 185V145.867Z" fill="white" />
          <path d="M111 145.867L91 127V159.145L111 185V145.867Z" fill="white" />
          <rect x="53" y="128" width="5" height="56" fill="white" />
          <circle cx="55.5" cy="102.5" r="14.5" fill="#D9E5F3" />
        </svg>
      </div>
    </footer>
  </body>
</html>
