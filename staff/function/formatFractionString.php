<?php 

function formatFractionString($fractionStr) {
    // Check if it's a mixed fraction like "1 1/4"
    if (preg_match('/^(\d+)\s+(\d+)\/(\d+)$/', $fractionStr, $matches)) {
        $whole = $matches[1];
        $num = $matches[2];
        $den = $matches[3];

        return "$whole <sup>$num</sup>&frasl;<sub>$den</sub>";
    }
    // Check if it's a simple fraction like "3/4"
    elseif (preg_match('/^(\d+)\/(\d+)$/', $fractionStr, $matches)) {
        $num = $matches[1];
        $den = $matches[2];

        return "<sup>$num</sup>&frasl;<sub>$den</sub>";
    }

    // Otherwise, return as-is
    return htmlspecialchars($fractionStr);
}

?>