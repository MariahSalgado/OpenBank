<?php
require_once 'config.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Transaction Page</title>
<link rel ="stylesheet" href="dashboard.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<a href="#" onclick="logout()" id="logout">Logout</a>
<h1>OpenBank</h1>
<form id="dashboardForm">
    Balance: <span id="balance">$0.00</span>
    <input type ="number" id="amount" placeholder="$0.00">
    <button type = "button" onclick="deposit()">Deposit</button>
    <button type ="button" onclick="withdraw()">Withdraw</button>
</form>
<div id="transactions" style = "margin-top: 20px;">
    <h2>Transactions</h2>
    <ul id="logList" style ="list-style-type: none;"></ul>
</div>

<script>
$(document).ready(function() {
    fetchBalance(); // Fetch initial balance on load
});

function fetchBalance() {
    $.ajax({
        url: 'fetch_balance.php', // PHP script to get the balance
        type: 'GET',
        success: function(response) {
            $('#balance').text(`$${parseFloat(response).toFixed(2)}`);
        },
        error: function() {
            alert("Failed to fetch balance");
        }
    });
}

function deposit() {
    let amount = parseFloat($('#amount').val());
    if (amount > 0) {
        $.ajax({
            url: 'update_balance.php', // Handle deposit
            type: 'POST',
            data: { amount: amount, type: 'deposit' },
            success: function(response) {
                console.log(response); // See what the actual response is
                if(response.includes("Transaction successful")) {
                    fetchBalance(); // Update balance display
                    transaction('Deposit', amount);
                } else {
                    alert(response); // Show actual error or response from the server
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Deposit failed: " + textStatus + ", " + errorThrown);
            }
        });
    } else {
        alert("Invalid amount, please try again.");
    }
}

function withdraw() {
    let amount = parseFloat($('#amount').val());
    if (amount > 0) {
        $.ajax({
            url: 'update_balance.php', // Handle withdrawal
            type: 'POST',
            data: { amount: amount, type: 'withdraw' },
            success: function(response) {
                console.log(response); // See what the actual response is
                if(response.includes("Transaction successful")) {
                    fetchBalance(); // Update balance display
                    transaction('Withdraw', amount);
                } else {
                    alert(response); // Show actual error or response from the server
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Withdrawal failed: " + textStatus + ", " + errorThrown);
            }
        });
    } else {
        alert("Invalid amount, please try again.");
    }
}

function transaction(type, amount) {
    const logList = document.getElementById('logList');
    const entry = document.createElement('li');
    entry.textContent = `${type}: $${amount.toFixed(2)}`;
    if (logList.children.length >= 20) {
        logList.removeChild(logList.firstChild);
    }
    logList.appendChild(entry);
}

//Function to logout

function logout(){
    $.ajax({
    url: 'logout.php', //URL to the logout.php
    type: 'POST',
    success: function(){
    alert("You have been logged out.");
    window.location.href = 'index.html'; // Takes user back to login page (index)
    },
    error: function(){
    alert("Logout has failed, try again.");
    }
    });
    }
</script>

</body>
</html>
