<?php
// app/Domain/Entities/Promotion.php
namespace App\business\entities;

class Promotion
{
    private $product;
    private $relatedProduct;  // For Meal Deals (e.g., D + E together)
    private $promotionType;
    private $quantity;
    private $discountedPrice;
    private $requiredQuantity;

    public function __construct(
        Product       $product,
        PromotionType $promotionType,
        ?Product      $relatedProduct = null,
        ?int          $quantity = null,
        ?int          $discountedPrice = null,
        ?int          $requiredQuantity = null
    )
    {
        $this->product = $product;
        $this->promotionType = $promotionType;
        $this->relatedProduct = $relatedProduct;
        $this->quantity = $quantity;
        $this->discountedPrice = $discountedPrice;
        $this->requiredQuantity = $requiredQuantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getRelatedProduct(): ?Product
    {
        return $this->relatedProduct;
    }

    public function getPromotionType(): PromotionType
    {
        return $this->promotionType;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function getDiscountedPrice(): ?int
    {
        return $this->discountedPrice;
    }

    public function getRequiredQuantity(): ?int
    {
        return $this->requiredQuantity;
    }
}
