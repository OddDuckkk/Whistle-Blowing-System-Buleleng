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

    // Validation Callback for 'file_lampiran'
    public function validate_file_lampiran($file, string $fields, array $data): bool
    {
        if (empty($file)) {
            return false;  // File is required
        }

        // Add your custom file validation logic here (e.g., checking mime types, size, etc.)
        if (!in_array($file->getMimeType(), ['image/jpg', 'image/jpeg', 'image/png', 'application/pdf'])) {
            return false;  // Invalid file type
        }

        if ($file->getSize() > 10240 * 1024) {
            return false;  // File size too large
        }

        return true;
    }

    // Validation Callback for 'deskripsi_lampiran'
    public function validate_deskripsi_lampiran($str, string $fields, array $data): bool
    {
        // Check that description is non-empty and valid
        if (empty($str)) {
            return false;  // Field is required
        }

        // Custom logic for validating description can be added here (e.g., length check)
        return true;
    }

    // Validation Callback for 'nama_terlapor'
    public function validate_nama_terlapor($str, string $fields, array $data): bool
    {
        // Custom validation logic for 'nama_terlapor'
        if (empty($str)) {
            return false;  // Field is required
        }
        return true;
    }

    // Validation Callback for 'jabatan_terlapor'
    public function validate_jabatan_terlapor($str, string $fields, array $data): bool
    {
        // Custom validation logic for 'jabatan_terlapor'
        if (empty($str)) {
            return false;  // Field is required
        }
        return true;
    }

    // Validation Callback for 'unit_kerja'
    public function validate_unit_kerja($str, string $fields, array $data): bool
    {
        // Custom validation logic for 'unit_kerja'
        if (empty($str)) {
            return false;  // Field is required
        }
        return true;
    }

}