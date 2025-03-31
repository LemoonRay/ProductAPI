<?php
require_once "config/Database.php";
require_once "repositories/interface/IProductRepository.php";

class ProductRepository implements IProductRepository {
    private $databaseConnection;
    private Database $database;
    
    public function __construct() {
        $this->database = Database::getInstance();
        $this->databaseConnection = $this->database->getConnection();
    }

    public function GetAllProduct() {
        $query = "SELECT 
                    p.ProductId, 
                    p.ProductName, 
                    pp.ProductPrice, 
                    pp.ProductDate 
                  FROM PRODUCT p
                  LEFT JOIN ProductDetails pp ON p.ProductId = pp.ProductId";
        
        return $this->ExecuteSqlQuery($query, []);
    }
    

    public function GetLatestPriceOfTheProduct() {
        $query = "SELECT 
                    p.ProductId, 
                    p.ProductName, 
                    pd.ProductPrice, 
                    pd.ProductDate
                  FROM PRODUCT p
                  JOIN PRODUCTDETAILS pd 
                    ON p.ProductId = pd.ProductId
                  WHERE pd.ProductDate = (
                      SELECT MAX(ProductDate) 
                      FROM PRODUCTDETAILS 
                      WHERE ProductId = p.ProductId
                  )";
        
        return $this->ExecuteSqlQuery($query, []);
    }
    

    public function GetProductById($productId) {
        $query = "SELECT 
                    p.ProductId, 
                    p.ProductName, 
                    pd.ProductPrice, 
                    pd.ProductDate
                  FROM PRODUCT p
                  INNER JOIN PRODUCTDETAILS pd ON pd.ProductId = p.ProductId
                  WHERE p.ProductId = :productId";

        return $this->ExecuteSqlQuery($query, [':productId' => $productId]);
    }

    private function ExecuteSqlQuery(string $query, array $params) {
        $statementObject = $this->databaseConnection->prepare($query);
        $statementObject->execute($params);

        if (stripos($query, "SELECT") === 0) {
            return $statementObject->fetchAll(PDO::FETCH_ASSOC);
        }

        return null;
    }
}
