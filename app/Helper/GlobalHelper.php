<?php

namespace App\Helper;

use App\Models\Tweek;

class GlobalHelper
{

    /**
     * Retrieve the commission percentage from the database.
     *
     * @return float The commission percentage. Returns 0 if not found.
     */

    public static function getCommissionPercentage()
    {
        $commission = Tweek::where('type', 'Withdrawal Commission Rate')->first();
        if ($commission) {
            return $commission->value;
        } else {
            return 0;
        }
    }

    /**
     * Calculate the amount of commission from a given amount
     *
     * @param float $amount The amount to calculate the commission from
     * @return float The amount of commission
     */
    public static function getCommissionedAmount($amount)
    {
        $commission = Tweek::where('type', 'Withdrawal Commission Rate')->first();
        if ($commission) {
            return $amount * ($commission->value / 100);
        } else {
            return 0;
        }
    }
    /**
     * Calculate the amount after commission
     *
     * @param float $amount
     * @return float
     */
    public static function getAmountAfterCommission($amount)
    {
        $commission = Tweek::where('type', 'Withdrawal Commission Rate')->first();
        if ($commission) {
            return $amount - ($amount * ($commission->value / 100));
        } else {
            return $amount;
        }
    }
}
