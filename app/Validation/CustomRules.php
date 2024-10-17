<?php

namespace App\Validation;

class CustomRules {

    /**
     * Custom validation untuk tanggal sehingga tidak terlalu jauh di masa lampau dan tidak di masa depan
     */
    public function custom_valid_date(string $date, string &$error = null): bool {
        $minDate = strtotime('-50 years'); // Change to the desired minimum date (e.g., 50 years ago)
        $maxDate = strtotime('today'); // No future dates allowed

        $inputDate = strtotime($date);

        if ($inputDate < $minDate || $inputDate > $maxDate) {
            return false;
        }

        return true;
    }
}