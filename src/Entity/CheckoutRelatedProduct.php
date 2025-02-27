<?php

namespace App\Entity;

use App\Repository\CheckoutRelatedProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CheckoutRelatedProductRepository::class)]
class CheckoutRelatedProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'checkoutRelatedProducts')]
    private ?Product $product = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'checkoutRelatedProducts')]
    private ?CheckoutRequest $request = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

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
