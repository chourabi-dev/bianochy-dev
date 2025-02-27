<?php

namespace App\Entity;

use App\Repository\CheckoutRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CheckoutRequestRepository::class)]
class CheckoutRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $address = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    /**
     * @var Collection<int, CheckoutRelatedProduct>
     */
    #[ORM\OneToMany(targetEntity: CheckoutRelatedProduct::class, mappedBy: 'request')]
    private Collection $checkoutRelatedProducts;

    /**
     * @var Collection<int, CheckoutRelatedProductPack>
     */
    #[ORM\OneToMany(targetEntity: CheckoutRelatedProductPack::class, mappedBy: 'request')]
    private Collection $checkoutRelatedProductPacks;

    #[ORM\ManyToOne(inversedBy: 'checkoutRequests')]
    private ?PaymentStatus $paymentStatus = null;

 
    public function __construct()
    {
        $this->checkoutRelatedProducts = new ArrayCollection();
        $this->checkoutRelatedProductPacks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

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
            $checkoutRelatedProduct->setRequest($this);
        }

        return $this;
    }

    public function removeCheckoutRelatedProduct(CheckoutRelatedProduct $checkoutRelatedProduct): static
    {
        if ($this->checkoutRelatedProducts->removeElement($checkoutRelatedProduct)) {
            // set the owning side to null (unless already changed)
            if ($checkoutRelatedProduct->getRequest() === $this) {
                $checkoutRelatedProduct->setRequest(null);
            }
        }

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
            $checkoutRelatedProductPack->setRequest($this);
        }

        return $this;
    }

    public function removeCheckoutRelatedProductPack(CheckoutRelatedProductPack $checkoutRelatedProductPack): static
    {
        if ($this->checkoutRelatedProductPacks->removeElement($checkoutRelatedProductPack)) {
            // set the owning side to null (unless already changed)
            if ($checkoutRelatedProductPack->getRequest() === $this) {
                $checkoutRelatedProductPack->setRequest(null);
            }
        }

        return $this;
    }

    public function getPaymentStatus(): ?PaymentStatus
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(?PaymentStatus $paymentStatus): static
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }
 
}
