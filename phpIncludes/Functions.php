<?php

$GMAIL_USER_NAME = "noreply@iqbrokers.us";
$GMAIL_PASSWORD = "eA{Q_G=y2Z=N";


function addressGenerator(){
    $address = '0123456789';
    $address = str_shuffle($address);
  
    return $address;
  }

  function PasswordGenerator(){
    $password = 'abc123456789';
    $password = str_shuffle($password);
  
    return $password;
  }
  
  function tokenGenerator($length){
    $toks = 'abcdefghijklMNOPQRSTUVwxyZ1234567890';
    $toks = str_shuffle($toks);
    $toks = substr($toks, 0, $length);
  
    return $toks;
  }

  function transactionIdGenerator(){
    $transactionId = '0123456789abcdefghij';
    $transactionId = str_shuffle($transactionId);
  
    return $transactionId;
  }



?>