<?php
session_start();
header('Content-Type: application/json');
$symbols = ['C','L','O','W'];
$roll_cost = 1;
$rewards = [
    'CCC' => 10,
    'LLL' => 20,
    'OOO' => 30,
    'WWW' => 40,
];
$chance = mt_rand(1, 100);

function roll(array $symbols, int $roll_cost, array $rewards): array
{
    for ($i = 0; $i < 3; $i++) {
        $fruits[] = $symbols[array_rand($symbols)];
    }
    $_SESSION['fruits'] = $fruits;
    $fruitKey = implode('', $fruits);

    if (isset($rewards[$fruitKey])) {
        $winAmount = $rewards[$fruitKey];
        $roll_result = [
            'balance' => $winAmount,
            'fruits'  => $fruits,
            'note'    => "WOW! You just won {$winAmount} credits!",
            'won'     => true,
        ];
    }
    else {
        $roll_result = [
            'balance' => -$roll_cost,
            'fruits'  => $fruits,
            'note'    => 'NOPE! Good luck next time!',
            'won'     => false,
        ];
    }

    return $roll_result;
}

// do the initial roll
$roll_result = roll($symbols,$roll_cost,$rewards);

// if won the initial roll and current balance between 40 and 60 - re roll with 30 percent chance
if($roll_result['won'] && 40 <= $_SESSION['balance'] && $_SESSION['balance'] <= 60 && $chance <= 30){
        $roll_result = roll($symbols,$roll_cost,$rewards);
}
// if won the initial roll and current balance greater than 60 - re roll with 60 percent chance
elseif($roll_result['won'] && $_SESSION['balance'] > 60 && $chance <= 60){
        $roll_result = roll($symbols,$roll_cost,$rewards);
}

// apply roll results and return it to frontend

$_SESSION['balance']   += $roll_result['balance'];
$_SESSION['note']       = $roll_result['note'];
$_SESSION['fruits']     = $roll_result['fruits'];

echo json_encode($_SESSION);