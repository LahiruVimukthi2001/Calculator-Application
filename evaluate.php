<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $expression = $_POST['expression'] ?? '';
    $expression = str_replace(['×', '÷'], ['*', '/'], $expression);

    // Basic security: allow only valid math characters
    if (preg_match('/[^0-9+\-.*\/()%]/', $expression)) {
        echo "Invalid";
        exit;
    }

    try {
        $result = eval("return $expression;");
        echo $result;

        // Save to history
        file_put_contents('history.txt', "$expression = $result\n", FILE_APPEND);
    } catch (Throwable $e) {
        echo "Error";
    }
}
?>
