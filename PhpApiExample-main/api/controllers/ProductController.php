<?php

require_once "repositories/ProductRepository.php";
require_once "repositories/interface/IProductRepository.php";

class ProductController {
    private $productRepository;

    public function __construct() {
        $this->productRepository = new ProductRepository();
    }

    public function getAllProduct() {
        echo json_encode($this->productRepository->GetAllProduct(), JSON_PRETTY_PRINT);
    }

    public function getLatestPriceOfTheProduct() {
        echo json_encode($this->productRepository->GetLatestPriceOfTheProduct(), JSON_PRETTY_PRINT);
    }

    public function getProductById($productId) {
        echo json_encode($this->productRepository->GetProductById($productId), JSON_PRETTY_PRINT);
    }
}
