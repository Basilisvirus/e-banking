<?php
session_start();
include_once 'ebanking_db.php';

$id = $_SESSION['id'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>

    </title>
    <style>
        body {
            background-color: #00281f;
            color: white;
        }
    </style>
</head>

<body>
    <?php
        if(isset($_GET['submit_amount'])){//if 'submit amount' pressed,
            //get all the input values except user. (in strings)
            $from = $_GET['from'];
            $to = $_GET['to'];
            $amount = $_GET['amount'];


            if (is_null($amount) || $amount == 0){
                $amount = 0;
            }

            //echo "$from"." "."$to"." "."$amount"."<br>";

            //if we want to sent to another user, also get 'User' input.
            //but check if there is a user input
            if($to == "User" && strlen($_GET['user_id'])>=1) {
                $receiver = $_GET['user_id'];
            }else{
                $receiver = NULL;
            }

            if($from != "Από" && $to != "Πρός"){//if user selected sender/receiver
                switch($from) {
                    case "Bank":
                        if ($amount >$_SESSION['bank_money']){
                            echo "Your balance is not enough";
                            $to = NULL;
                        }else{
                            echo "you send ".$amount."€ from your Bank ";
                        }
                        break;
                    case "Card":
                        if($amount >$_SESSION['card_money']){
                            echo "Your balance is not enough";
                            $to = NULL;
                        }else{
                            echo "you send ".$amount."€ from your Card ";
                        }

                        break;
                }

                //check the receiver inputs
                switch($to){
                    case "Bank":
                        echo "to your Bank"."<br>";
                        $sql = "UPDATE funds SET bank = bank + $amount WHERE id = $id";
                        mysqli_query($funds, $sql);//rows with user table

                        $sql = "UPDATE funds SET card = card - $amount WHERE id = $id";
                        mysqli_query($funds, $sql);//rows with user table

                        break;
                    case "Card":
                        echo "to your Card"."<br>";
                        $sql = "UPDATE funds SET card = card + $amount WHERE id = $id";
                        mysqli_query($funds, $sql);//rows with user table

                        $sql = "UPDATE funds SET bank = bank - $amount WHERE id = $id;";
                        mysqli_query($funds, $sql);//rows with user table

                        break;
                    case "User":
                        if(is_null($receiver)){//if id was not present,
                            echo "but you didnt select a user's id";
                        }else{
                            echo "to another user, with id of $receiver"."<br>";
                            $sql = "SELECT * FROM users WHERE id = $receiver";
                            $results = mysqli_query($users, $sql);
                            $resultCheck = mysqli_num_rows($results);

                            if($resultCheck == 1){//if there is only one user with this id

                                //add money to the receiver
                                $sql = "UPDATE funds SET bank = bank + $amount WHERE id = $receiver;";
                                mysqli_query($funds, $sql);

                                //abstract money from the sender
                                $sql = "UPDATE funds SET $from = $from - $amount WHERE id = $id;";
                                mysqli_query($funds, $sql);

                                echo "Successfully sent money to ";
                                $row = mysqli_fetch_assoc($results);
                                echo $row['nickname'];
                                echo "<br>";
                            }else{
                                echo "No user with this id found";
                            }

                        }

                }


            }else if ($from == "Από" || $to == "Πρός"){//if user didnt select sender/receiver
                echo "You must select both valid 'from' and 'to' fields";
            }

        }//end of if 'submit amount' pressed.
        else{
            echo"did you get here for debugging? no submit has been pressed";
        }

    ?>

</body>


</html>
