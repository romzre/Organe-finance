<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\CategoryRepository;

class ServiceDefaultCategory extends AbstractService
{
    private CategoryRepository $Categoryrepository;
    public const DEFAULTCATEGORIES = [
        [
            "label" => "Alimentation",
            "color" => "#0aab35"
        ],
        [
            "label" => "Divers",
            "color" => "#363636"
        ],
        [
            "label" => "Plaisir",
            "color" => "#a632a8"
        ],
        [
            "label" => "Salaire",
            "color" => "#077807"
        ],
        [
            "label" => "Loyer",
            "color" => "#9faa0e"
        ],
        [
            "label" => "Restaurant",
            "color" => "#bb0707"
        ],
        [
            "label" => "Loisir",
            "color" => "#fff700"
        ],
        [
            "label" => "Assurance",
            "color" => "#696969"
        ],
        [
            "label" => "Shopping",
            "color" => "#e2187a"
        ],
        [
            "label" => "Aides",
            "color" => "#259dd0"
        ],
        [
            "label" => "Crédit",
            "color" => "#250ca1"
        ],
        [
            "label" => "Santé",
            "color" => "#57045d"
        ],
        [
            "label" => "Impots",
            "color" => "#ff9b0f"
        ],
    ];

    public function __construct(CategoryRepository $Categoryrepository)
    {
        $this->Categoryrepository = $Categoryrepository;
    }

    public function addDefaultCategories(User $user)
    {
        
    }

}