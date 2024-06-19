<?php
namespace Services;

use Api\BinServiceInterface;
use Exceptions\WarningException;

class BinService implements BinServiceInterface
{
    public function isEu($bin): bool
    {
        set_error_handler(function($severity, $message, $file, $line) {
            throw new WarningException($message, 0);
        });

        try {
            $response = @file_get_contents('https://lookup.binlist.net/' . $bin);
            if ($response === false) {
                return false;
            }

            $response = json_decode($response);
            if (empty($response) || empty($response->country) || empty($response->country->alpha2)) {
                return false;
            }

            $alpha2 = $response->country->alpha2;
            return in_array($alpha2, [
                'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT',
                'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'
            ]);

        } catch (WarningException $e) {
            return false;
        } finally {
            restore_error_handler();
        }
    }
}
