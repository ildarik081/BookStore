<?php

namespace App\Component\Interface;

use App\Entity\Product;

interface ProductInterface
{
    public function getId(): ?int;
    public function getQuantity(): ?int;
    public function setQuantity(int $quantity): self;
    public function getProduct(): ?Product;
    public function setProduct(?Product $product): self;
}
