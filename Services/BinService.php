<?php
namespace Services;


use Api\BinServiceInterface;

class BinService implements BinServiceInterface
{
    public function isEu($bin)
    {
        $response = json_decode(file_get_contents('https://lookup.binlist.net/' . $bin));
        $alpha2 = $response->country->alpha2;
        return in_array($alpha2, ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK']);
    }
}
