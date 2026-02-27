<!doctype html>
<html lang="pl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ZGLOSZENIA</title>
  <link rel="stylesheet" href="styl.css" />
</head>

<body>
  <?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "zgloszenia";

  $conn = mysqli_connect($servername, $username, $password, $dbname);


  if (!$conn) {
    echo mysqli_error($conn);
  }
  ?>
  <header>
    <h1>Zgloszenia wydarzeń</h1>
  </header>
  <main>
    <section class="left">
      <h2>Personel</h2>
      <form method="post">
        <input type="radio" name="radi" id="Policjant" value="policjant" checked />
        <label for="Policjant">Policjant</label>
        <input type="radio" name="radi" id="Ratownik" value="ratownik" />
        <label for="Ratownik">Ratownik</label>
        <button type="submit" id="button">Pokaz</button>
      </form>

      <?php
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST["radi"])) {
          $conn = mysqli_connect($servername, $username, $password, $dbname);
          $polOrRat = $_POST["radi"];
          $select_query = "SELECT `id`, `imie`, `nazwisko` FROM `personel` WHERE personel.status = '$polOrRat'";


          $opcja = $_POST["radi"];
          echo "<h3>Wybrano opcję: $opcja </h3>";
          echo "
          <table>
            <tr>
              <th>Id</th>
              <th>Imie</th>
              <th>Nazwisko</th>
            </tr>
          ";
          $lp = 0;
          $result = mysqli_query($conn, $select_query);
          $rows = mysqli_num_rows($result);
          while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $lp++ . "</td>";
            echo "<td>" . $row['imie'] . "</td>";
            echo "<td>" . $row['nazwisko'] . "</td>";
            echo "</tr>";
          }
          $result = mysqli_query($conn, $select_query);

          echo "</table>";
          mysqli_close($conn);
        }
      }
      ?>

    </section>
    <section class="right">
      <h2>Nowe zgloszenie</h2>
      <ol>
        <?php
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        $query = "SELECT personel.id, personel.nazwisko FROM personel WHERE personel.id NOT IN(SELECT rejestr.id_personel FROM rejestr)";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_num_rows($result);

        $lp = 0;
        while ($row = mysqli_fetch_array($result)) {
          echo "<li>";
          echo $row['id'] . " " . $row['nazwisko'];
          echo "</li>";
        }
        mysqli_close($conn);
        ?>
      </ol>
      <form method="post">
        <label for="Osoba">Wybierz id ososby z listy</label>
        <input type="number" id="Osoba" name="Osoba" />
        <button type="submit">Dodaj zgloszenie</button>

        <?php

        // if $_POST[Osoba] istnieje
        // to polacz z bazą danych
        // wykonaj query
        

        if (isset($_POST['Osoba'])) {
          $id = $_POST['Osoba'];
          $conn = mysqli_connect($servername, $username, $password, $dbname);
          $query1 = "INSERT INTO `rejestr`(`data`, `id_personel`, `id_pojazd`) VALUES (CURRENT_DATE, $id ,14);";
          $result = mysqli_query($conn, $query1);

          mysqli_close($conn);
        }
        ?>
      </form>
    </section>
  </main>
  <footer>
    <p>Strone wykonal: Feranen</p>
  </footer>
</body>

</html>