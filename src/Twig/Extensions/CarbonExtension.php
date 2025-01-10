<?php

namespace App\Twig\Extension;

use Carbon\Carbon;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CarbonExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            // Ajoute le filtre 'ago' pour utiliser Carbon
            new TwigFilter('ago', [$this, 'agoFilter']),
        ];
    }

    /**
     * Cette méthode utilise Carbon pour renvoyer une date relative.
     */
    public function agoFilter($date)
    {
        // S'assurer que la date est bien un objet Carbon ou une date valide
        return Carbon::parse($date)->diffForHumans();
    }
}
