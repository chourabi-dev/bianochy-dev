<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1000)]
    private ?string $label = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descreption = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    private ?bool $enStock = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $subtitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $features = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $howToUse = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $delivery = null;

    /**
     * @var Collection<int, ProductImage>
     */
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductImage::class, cascade: ['persist'])]
    private Collection $images;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\OneToMany(targetEntity: Ingredient::class, mappedBy: 'product')]
    private Collection $ingredient;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?SubCategory $subCategory = null;

    /**
     * @var Collection<int, ProductsPack>
     */
    #[ORM\ManyToMany(targetEntity: ProductsPack::class, mappedBy: 'products')]
    private Collection $productsPacks;

    /**
     * @var Collection<int, ProductReview>
     */
    #[ORM\OneToMany(targetEntity: ProductReview::class, mappedBy: 'product')]
    private Collection $productReviews;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Perfum $perfum = null;

    /**
     * @var Collection<int, CheckoutRelatedProduct>
     */
    #[ORM\OneToMany(targetEntity: CheckoutRelatedProduct::class, mappedBy: 'product')]
    private Collection $checkoutRelatedProducts;


 

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->ingredient = new ArrayCollection();
        $this->productsPacks = new ArrayCollection();
        $this->productReviews = new ArrayCollection();
        $this->checkoutRelatedProducts = new ArrayCollection();
    }

    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

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

    public function getDescreption(): ?string
    {
        return $this->descreption;
    }

    public function setDescreption(?string $descreption): static
    {
        $this->descreption = $descreption;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    } 

    public function isEnStock(): ?bool
    {
        return $this->enStock;
    }

    public function setEnStock(bool $enStock): static
    {
        $this->enStock = $enStock;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getFeatures(): ?string
    {
        return $this->features;
    }

    public function setFeatures(?string $features): static
    {
        $this->features = $features;

        return $this;
    }

    public function getHowToUse(): ?string
    {
        return $this->howToUse;
    }

    public function setHowToUse(?string $howToUse): static
    {
        $this->howToUse = $howToUse;

        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(?string $delivery): static
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * @return Collection<int, ProductImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ProductImage $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(ProductImage $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }



    function __toString()
    {
        return $this->label;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredient(): Collection
    {
        return $this->ingredient;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredient->contains($ingredient)) {
            $this->ingredient->add($ingredient);
            $ingredient->setProduct($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->ingredient->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getProduct() === $this) {
                $ingredient->setProduct(null);
            }
        }

        return $this;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?SubCategory $subCategory): static
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * @return Collection<int, ProductsPack>
     */
    public function getProductsPacks(): Collection
    {
        return $this->productsPacks;
    }

    public function addProductsPack(ProductsPack $productsPack): static
    {
        if (!$this->productsPacks->contains($productsPack)) {
            $this->productsPacks->add($productsPack);
            $productsPack->addProduct($this);
        }

        return $this;
    }

    public function removeProductsPack(ProductsPack $productsPack): static
    {
        if ($this->productsPacks->removeElement($productsPack)) {
            $productsPack->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductReview>
     */
    public function getProductReviews(): Collection
    {
        return $this->productReviews;
    }

    public function addProductReview(ProductReview $productReview): static
    {
        if (!$this->productReviews->contains($productReview)) {
            $this->productReviews->add($productReview);
            $productReview->setProduct($this);
        }

        return $this;
    }

    public function removeProductReview(ProductReview $productReview): static
    {
        if ($this->productReviews->removeElement($productReview)) {
            // set the owning side to null (unless already changed)
            if ($productReview->getProduct() === $this) {
                $productReview->setProduct(null);
            }
        }

        return $this;
    }

    public function getPerfum(): ?Perfum
    {
        return $this->perfum;
    }

    public function setPerfum(?Perfum $perfum): static
    {
        $this->perfum = $perfum;

        return $this;
    }

    /**
     * @return Collection<int, CheckoutRelatedProduct>
     */
    public function getCheckoutRelatedProducts(): Collection
    {
        return $this->checkoutRelatedProducts;
    }

    public function addCheckoutRelatedProduct(CheckoutRelatedProduct $checkoutRelatedProduct): static
    {
        if (!$this->checkoutRelatedProducts->contains($checkoutRelatedProduct)) {
            $this->checkoutRelatedProducts->add($checkoutRelatedProduct);
            $checkoutRelatedProduct->setProduct($this);
        }

        return $this;
    }

    public function removeCheckoutRelatedProduct(CheckoutRelatedProduct $checkoutRelatedProduct): static
    {
        if ($this->checkoutRelatedProducts->removeElement($checkoutRelatedProduct)) {
            // set the owning side to null (unless already changed)
            if ($checkoutRelatedProduct->getProduct() === $this) {
                $checkoutRelatedProduct->setProduct(null);
            }
        }

        return $this;
    }

 


 
}
