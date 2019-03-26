<?php
session_start();
include_once 'ebanking_db.php';



function register($email, $nick, $pass, $users, $funds){
    $sql = "INSERT INTO users (email, nickname, password) VALUES ('$email', '$nick', '$pass');";

    //first registration bonus
    $userBonus = "INSERT INTO funds ( bank, card) VALUES ('100', '50');";


    if(mysqli_query($funds, $userBonus)){//put the money in. if true, insertion success
        echo "bonus success"."<br>";
    }else{//insertion failed
        echo "bonus failed. check the database (debug info)"."<br>";
    }//end of insertion failed

    if(mysqli_query($users, $sql)){//if true, insertion success
        echo "Register success"."<br>";
    }else{//insertion failed
        echo "Registration failed. check the database (debug info)"."<br>";
    }//end of insertion failed

}

//used to retrieve user's id from database i case of registering.
//you can use the output as: $var = user_id(...) and then echo $var[id]
function user_id($email, $users){
    $sql = "SELECT id FROM users WHERE email = '$email' ;"; //$email var needs to have the  '..' around it cause of the sql syntax
    $results = mysqli_query($users, $sql); //object
    $resultCheck = mysqli_num_rows($results); //number of results (rows)


    if($resultCheck){//if there are any results
        return mysqli_fetch_assoc($results);
    }else{
        echo "could not find user id with this email"."<br>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>
        Ebanking v1.0 Login
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
    if (isset($_GET['submit'])) { //if submit got pressed

        $typeSubmit = $_GET['typeOfSubmission'];

        //make variables that check if email, nickname and pass are empty
        $emptyEmail = ((strlen($_GET['email'])) < 4 );
        $emptyPass = ((strlen($_GET['pass'])) < 4 );

        if (!$emptyEmail && !$emptyPass && (((strlen($_GET['nick'])>4)&&($typeSubmit == "Register"))||($typeSubmit == "Sign in"))) {//if email and pass are not empty
            $email = $_GET['email'];
            $pass = $_GET['pass'];


            //store these until browser is closed.
            $_SESSION['email'] = $email;
            $_SESSION['pass'] =$pass;
            $_SESSION['id'] = -2; //-2 means user is not found in database

            $sql = "SELECT * FROM users;"; //take all users
            $results = mysqli_query($users, $sql);//rows with user table
            $resultCheck = mysqli_num_rows($results); //number of results (rows)

//if user wants to sign in
            if($typeSubmit == "Sign in"){

                if($resultCheck > 0){//if you find any users
                    while($row = mysqli_fetch_assoc($results)){
                        if ($row['email'] == $email) {//if given email is registered
                            echo "email exists"."<br>";
                            $_SESSION['id'] = -1;//-1 means email is registered, but not password
                            if($row['password'] == $pass){//if password is correct
                                echo "password correct"."<br>";
                                $_SESSION['id'] = $row['id']; //give the user's id

                            }else{//if your password is not correct
                                $_SESSION['id'] = 0; //0 means wrong password
                            }
                        }
                    }
                    if ($_SESSION['id'] == -2){//-2 means no email/pass found
                        echo "This email does not exist"."<br>";
                        echo '<a href="login_page.php">Try again</a><br>';
                    }else if($_SESSION['id'] == -1 || $_SESSION['id'] == 0){ //only email found
                        echo "wrong password"."<br>";
                        echo '<a href="login_page.php">Try again</a><br>';
                    }else{//we need to find the users nickname from the database, pass it to the season nickname

                        $sql = "SELECT nickname FROM users WHERE email = '$email' ;"; //$email var needs to have the  '..' around it cause of the sql syntax
                        $results = mysqli_query($users, $sql); //object
                        $resultCheck = mysqli_num_rows($results); //number of results (rows)

                        if($resultCheck){//if there are any results
                            $nick = mysqli_fetch_assoc($results);

                            $_SESSION['nick'] = $nick['nickname'];
                        }else{
                            echo "could not find user id with this email"."<br>";
                        }
                         echo $nick['nickname'];
                         echo " ";
                         echo "You will be redirected to your account"."<br>";
                         echo '<a href="account.php">account.php</a>';
                    }
                } else {//if there are no users registered, This email does not exist
                    echo "This email does not exist"."<br>";
                    echo '<a href="login_page.php">Go register</a><br>';
                }
            }//end if user wants to sign in

//if user wants to register (pass already checked >=4 characters).
            else if($typeSubmit == "Register"){
                if($resultCheck > 0){
                    //search in while until there are no more lines or state (id) has changed
                    while($row = mysqli_fetch_assoc($results)){
                        if($row['email'] == $email){//if given email is registered
                            echo "email already in use, pick another email or sign in"."<br>";
                            $_SESSION['id'] = -1; //-1 means email in use
                            echo '<a href="login_page.php">Try again</a><br>';
                            break;
                        }
                    }//end of while
                    if($_SESSION['id'] == -2){
                        echo "you will now be registered and redirected to your account"."<br>";
                        $nick = $_GET['nick'];
                        $_SESSION['nick'] = $nick;
                        register($email, $nick, $pass, $users, $funds);

                        //find user's id that created by database
                        $user_id = user_id($email, $users);
                        echo "Note down your unique ID: "."<br>";
                        echo $user_id['id'];
                        $_SESSION['id'] = $user_id['id'];
                        echo '<a href="account.php">account.php</a>';
                    }
                }//end if resultCheck >0
                else{//if no one is registered
                    $nick = $_GET['nick'];
                    $_SESSION['nick'] = $nick;
                    register($email, $nick, $pass, $users, $funds);
                    echo "you will now be registered and redirected to your account"."<br>";

                    //find user's id that created by database
                    $user_id = user_id($email, $users);
                    echo "Note down your unique ID: "."<br>";
                    echo $user_id['id'];
                    $_SESSION['id'] = $user_id['id'];
                    echo '<a href="account.php">account.php</a>';
                }//end of else there are no one registered yet
            }//end of if user wants to register

        }else {//if email or pass are empty
            echo "you should fill both email, Nickname and password properly"."<br>";
            echo '<a href="login_page.php">Try again</a><br>';
        }
    }else {//if submit didnt pressed and you are on this file
        echo "You probably used the debugging link";
    }

?>

</body>
</html>