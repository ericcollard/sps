<?php

namespace App\Entity;

class SkidayOptions
{
    public int $accomodationNonracerPlaceCount = -1;
    public int $skipassNonracerCount = -1;
    public int $transportAllerNonracerPlaceCount = -1;
    public int $transportAllerAvailablePlaceCount = -1;
    public int $transportRetourNonracerPlaceCount = -1;
    public int $transportRetourAvailablePlaceCount = -1;

    public int $skidayRacerId = -1;
    public int $accomodationRacerId = -1;
    public int $transportRacerAllerId = -1;
    public int $transportRacerRetourId = -1;
    public int $racerId = -1;

}
