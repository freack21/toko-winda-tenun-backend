<?php

namespace App\Helpers;

class CurrencyFormatter
{
  public static function formatRupiah($value)
  {
    return 'Rp. ' . number_format($value, 0, ',', '.');
  }
}
