<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Calculator</title>
    <link rel="stylesheet" href="">
</head>
<body>


<div class="calculator">
    <div class="top-bar"><center>PHP Calculator</center></div>
    <div class="display" id="display">0</div>

    <div class="buttons">
        <button onclick="clearDisplay()" class="red">C</button>
        <button onclick="appendToDisplay('(')">(</button>
        <button onclick="appendToDisplay(')')">)</button>
        <button onclick="appendToDisplay('/')" class="blue">/</button>

        <button onclick="appendToDisplay('7')">7</button>
        <button onclick="appendToDisplay('8')">8</button>
        <button onclick="appendToDisplay('9')">9</button>
        <button onclick="appendToDisplay('*')" class="blue">×</button>

        <button onclick="appendToDisplay('4')">4</button>
        <button onclick="appendToDisplay('5')">5</button>
        <button onclick="appendToDisplay('6')">6</button>
        <button onclick="appendToDisplay('-')" class="blue">−</button>

        <button onclick="appendToDisplay('1')">1</button>
        <button onclick="appendToDisplay('2')">2</button>
        <button onclick="appendToDisplay('3')">3</button>
        <button onclick="appendToDisplay('+')" class="blue">+</button>

        <button onclick="appendToDisplay('0')">0</button>
        <button onclick="appendToDisplay('.')">.</button>
        <button onclick="deleteLast()">⌫</button>
        <button onclick="calculate()" class="green">=</button>
    </div>

    <div class="history">
        <h4>Calculation History</h4>
        <div id="history">
            <?php
            if (file_exists('history.txt')) {
                echo nl2br(file_get_contents('history.txt'));
            }
            ?>
        </div>
        <button onclick="clearHistory()" 
                class="red" style="margin-top: 5px; width:100%; ">Clear History</button>
    </div>    
</div>

<script>
    function appendToDisplay(value) {
        const display = document.getElementById('display');
        if (display.innerText === '0') {
            display.innerText = value;
        } else {
            display.innerText += value;
        }
    }

    function clearDisplay() {
        document.getElementById('display').innerText = '0';
    }

    function deleteLast() {
        const display = document.getElementById('display');
        display.innerText = display.innerText.slice(0, -1) || '0';
    }

    function calculate() {
        const expression = document.getElementById('display').innerText;
        fetch('evaluate.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'expression=' + encodeURIComponent(expression)
        })
        .then(res => res.text())
        .then(result => {
            document.getElementById('display').innerText = result;
            fetch('history.txt')
                .then(res => res.text())
                .then(history => {
                    document.getElementById('history').innerHTML = history.replace(/\n/g, "<br>");
                });
        });
    }

    function clearHistory() {
        fetch('clear_history.php', { method: 'POST' })
            .then(() => document.getElementById('history').innerHTML = '');
    }
</script>




</body>
</html>