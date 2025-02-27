<?php

namespace App\Entity;

use App\Repository\PaymentStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentStatusRepository::class)]
class PaymentStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, CheckoutRequest>
     */
    #[ORM\OneToMany(targetEntity: CheckoutRequest::class, mappedBy: 'paymentStatus')]
    private Collection $checkoutRequests;

    public function __construct()
    {
        $this->checkoutRequests = new ArrayCollection();
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

    /**
     * @return Collection<int, CheckoutRequest>
     */
    public function getCheckoutRequests(): Collection
    {
        return $this->checkoutRequests;
    }

    public function addCheckoutRequest(CheckoutRequest $checkoutRequest): static
    {
        if (!$this->checkoutRequests->contains($checkoutRequest)) {
            $this->checkoutRequests->add($checkoutRequest);
            $checkoutRequest->setPaymentStatus($this);
        }

        return $this;
    }

    public function removeCheckoutRequest(CheckoutRequest $checkoutRequest): static
    {
        if ($this->checkoutRequests->removeElement($checkoutRequest)) {
            // set the owning side to null (unless already changed)
            if ($checkoutRequest->getPaymentStatus() === $this) {
                $checkoutRequest->setPaymentStatus(null);
            }
        }

        return $this;
    }
}
