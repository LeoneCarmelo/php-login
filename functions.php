<?php

function check_login($connection) 
{
    if(isset($_SESSION['nome'])) //if this value exist
    {
        $nome = $_SESSION['nome'];
        $query = "select * from utenti where nome = '$nome' limit 1";
        $result = mysqli_query($connection, $query);
        if($result && mysqli_num_rows($result) > 0)
        {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }
    // Redirect to login views if the use is not logged in
    header("Location: login.php");
    die;
}

function get_events_for_user($connection)
{
    //save the email of the logged user into a variable to use it in the query below
    $email = $_SESSION["email"];
    $query = "select * from eventi where attendees like '%$email%' limit 5"; //%$email%
    $result = mysqli_query($connection, $query);
    if($result && mysqli_num_rows($result) > 0)
    {
        $events = [];
        while($row = mysqli_fetch_assoc($result)){//save every row into the array
            $events[] = $row;
        }
        return $events;
    }
    return 'Nessun evento trovato!';
}

function get_events_for_admin($connection)
{
    $query = "select * from eventi"; 
    $result = mysqli_query($connection, $query);
    if($result && mysqli_num_rows($result) > 0)
    {
        $events = [];
        while($row = mysqli_fetch_assoc($result)){//save every row into the array
            $events[] = $row;
        }
        return $events;
    }
    return 'Nessun evento trovato!';
}

function check_password($password, $confirm_password) {
    if($password === $confirm_password){
        return true;
    }
}
