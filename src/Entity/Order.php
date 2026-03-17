<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Symfony\Component\Uid\Uuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`orders`')]
class Order
{
    #[ORM\Id]
    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class)]
    private Collection $products;

    #[ORM\Column]
    private ?bool $isPayed = null;

    #[ORM\Column]
    private ?bool $isFinish = null;

    public function __construct()
    {
        if ($this->uuid === null) {
            $this->uuid = Uuid::v4()->toRfc4122();
        }
        $this->products = new ArrayCollection();
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
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

    public function isPayed(): ?bool
    {
        return $this->isPayed;
    }

    public function setIsPayed(bool $isPayed): static
    {
        $this->isPayed = $isPayed;

        return $this;
    }

    public function isFinish(): ?bool
    {
        return $this->isFinish;
    }

    public function setIsFinish(bool $isFinish): static
    {
        $this->isFinish = $isFinish;

        return $this;
    }
}
