<?php

namespace App\Entity;

use App\Repository\SupAdminRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupAdminRepository::class)]
class SupAdmin extends User
{
}
