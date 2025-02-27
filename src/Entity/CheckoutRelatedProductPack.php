<?php

namespace App\Entity;

use App\Repository\CheckoutRelatedProductPackRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CheckoutRelatedProductPackRepository::class)]
class CheckoutRelatedProductPack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'checkoutRelatedProductPacks')]
    private ?ProductsPack $pack = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'checkoutRelatedProductPacks')]
    private ?CheckoutRequest $request = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPack(): ?ProductsPack
    {
        return $this->pack;
    }

    public function setPack(?ProductsPack $pack): static
    {
        $this->pack = $pack;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getRequest(): ?CheckoutRequest
    {
        return $this->request;
    }

    public function setRequest(?CheckoutRequest $request): static
    {
        $this->request = $request;

        return $this;
    }
}
