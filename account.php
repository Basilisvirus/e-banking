<?php
session_start();
$nick = $_SESSION['nick'];
$id = $_SESSION['id'];
include_once 'ebanking_db.php';

//to find how much money you have on your account
function balance($bk_cr, $funds, $id){
    $sql = "SELECT $bk_cr FROM funds WHERE id = $id;";
    $results = mysqli_query($funds, $sql);//object
    $resultCheck = mysqli_num_rows($results); //number of results (rows)

    if($resultCheck) {//if there are any users with this id
        return mysqli_fetch_assoc($results);
    }else{
        echo "i could not find your $bk_cr money"."<br>";
        echo $_SESSION['id'];
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ebanking v1.0</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }
        .column {
            float: left;
            width: 33.33%;
            padding: 1px;
        }
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        table, th, td {
            border: 3px solid white;
        }
        body {
            background-color: #00281f;
            color: white;
        }
    </style>
</head>
<body>


             <!--split the page in Three Columns-->
                       <!--First Column-->
<div class="row">
    <div class="column">
        <!-- Sidebar -->
        <div class="w3-sidebar w3-light-grey w3-bar-block" style="width:25%">
            <h3 class="w3-bar-item">Συνεργαζόμενες εταιρίες</h3>
            <a href="#" class="w3-bar-item w3-button">ΔΕΗ</a>
            <a href="#" class="w3-bar-item w3-button">ΟΤΕ</a>
            <a href="#" class="w3-bar-item w3-button">CYTA</a>
        </div>
    </div>
                      <!-- Second Column-->
    <div class="column">

        <?php
        echo '<div style = "text-align: center">';
        echo "Καλώς ορίσατε, "."$nick";
        echo '</div>';
        echo '<hr>';

        $bank_money = balance("bank", $funds, $id);
        $card_money = balance("card", $funds, $id);

        $_SESSION['bank_money'] = $bank_money['bank'];
        $_SESSION['card_money'] = $card_money['card'];
        ?>
                         <!--Υπόλοιπο-->
        <table align="center">
            <caption>Υπόποιπο</caption>
            <tr>
                <th>Κάρτα</th>
                <th>Τράπεζα</th>
            </tr>
            <tr>
                <td><?php echo $card_money['card'] ?></td>
                <td><?php echo $bank_money['bank'] ?></td>
            </tr>
        </table><hr>
                    <!-- Money transfer-->
        <div style = "text-align: center">Μεταφορά Χρημάτων</div>
        <form action = "transfer.php" method= "get">
            Ποσό: <input type="text" name="amount" placeholder = "340" /><br /><br />
            Χρήστης (id): <input type="text" name="user_id" placeholder = "if you transfer to user" /><br /><br />
            <input type= "submit" name="submit_amount" value="Submit amount" />
            <!-- dropdown menu-->
            <select name="from">
                <option>Από</option>
                <option>Bank</option>
                <option>Card</option>
            </select>
            <select name="to">
                <option>Πρός</option>
                <option>Card</option>
                <option>Bank</option>
                <option>User</option>
            </select>

        </form>
    </div>
                     <!-- Third column-->
    <div class="column">
        <p style="text-align: right;">
            Ο Λογαριασμός μου
        </p>
        <p style="text-align: right;">
            Αποσύνδεση
        </p>
    </div>
</div>

</body>
</html>
