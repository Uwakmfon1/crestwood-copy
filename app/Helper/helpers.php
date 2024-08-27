<?php

/**
 * Convert a duration string (e.g., '1w', '4w', '1m', '4m', '1y') to the number of days.
 *
 * @param string $duration
 * @return int
 */
function durationToDays(string $duration): int
{
    // Extract the numeric part and the unit part from the duration string
    preg_match('/(\d+)([wdmy])/', $duration, $matches);
    
    // Check if matches were found
    if (count($matches) !== 3) {
        throw new InvalidArgumentException('Invalid duration format.');
    }

    $value = (int)$matches[1];
    $unit = $matches[2];

    // Convert the duration based on the unit
    switch ($unit) {
        case 'w':
            return $value * 7; // Weeks to days
        case 'm':
            return $value * 31; // Approximate months to days
        case 'y':
            return $value * 365; // Approximate years to days
        default:
            throw new InvalidArgumentException('Invalid duration unit.');
    }
}
