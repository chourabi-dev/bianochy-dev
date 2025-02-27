<?php

namespace App\Entity;

use App\Repository\ProductsPackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsPackRepository::class)]
class ProductsPack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1000)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descreption = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column]
    private ?float $price = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'productsPacks')]
    private Collection $products;

    /**
     * @var Collection<int, CheckoutRelatedProductPack>
     */
    #[ORM\OneToMany(targetEntity: CheckoutRelatedProductPack::class, mappedBy: 'pack')]
    private Collection $checkoutRelatedProductPacks;

 

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->checkoutRelatedProductPacks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescreption(): ?string
    {
        return $this->descreption;
    }

    public function setDescreption(?string $descreption): static
    {
        $this->descreption = $descreption;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        $this->products->removeElement($product);

        return $this;
    }

    /**
     * @return Collection<int, CheckoutRelatedProductPack>
     */
    public function getCheckoutRelatedProductPacks(): Collection
    {
        return $this->checkoutRelatedProductPacks;
    }

    public function addCheckoutRelatedProductPack(CheckoutRelatedProductPack $checkoutRelatedProductPack): static
    {
        if (!$this->checkoutRelatedProductPacks->contains($checkoutRelatedProductPack)) {
            $this->checkoutRelatedProductPacks->add($checkoutRelatedProductPack);
            $checkoutRelatedProductPack->setPack($this);
        }

        return $this;
    }

    public function removeCheckoutRelatedProductPack(CheckoutRelatedProductPack $checkoutRelatedProductPack): static
    {
        if ($this->checkoutRelatedProductPacks->removeElement($checkoutRelatedProductPack)) {
            // set the owning side to null (unless already changed)
            if ($checkoutRelatedProductPack->getPack() === $this) {
                $checkoutRelatedProductPack->setPack(null);
            }
        }

        return $this;
    }

  
}
