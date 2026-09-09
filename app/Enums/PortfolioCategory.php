<?php

namespace App\Enums;

enum PortfolioCategory: string
{
    case Rumah = 'rumah';
   
    case Kantor = 'kantor';
     case CustomInterior = 'custom_interior';

    /**
     * Get the display label for the category.
     */
    public function label(): string
    {
        return match ($this) {
            self::Rumah => 'Rumah',
            self::Kantor => 'Kantor',
            self::CustomInterior => 'Custom Interior',
        };
    }
}
