# Encapsulation and Abstraction in PHP OOP

## Table of Contents
1. [Encapsulation](#encapsulation)
2. [Abstraction](#abstraction)
3. [Practical Examples](#practical-examples)
4. [Best Practices](#best-practices)
5. [Common Mistakes](#common-mistakes)

## Encapsulation

**Definition**: Encapsulation is the bundling of data (properties) and methods that operate on that data within a single unit (class), while restricting direct access to some of the object's components.

### Visibility Modifiers in PHP

#### 1. **Private** (`private`)
- Accessible only within the same class
- Not inherited by child classes
- Provides maximum data protection

```php
class User {
    private $password;  // Only accessible within User class
    
    private function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
```

#### 2. **Protected** (`protected`)
- Accessible within the class and its subclasses
- Not accessible from outside the class hierarchy
- Useful for inheritance while maintaining encapsulation

```php
class Vehicle {
    protected $engine;  // Accessible in Vehicle and its subclasses
    
    protected function startEngine() {
        $this->engine = "running";
    }
}

class Car extends Vehicle {
    public function drive() {
        $this->startEngine();  // Can access protected method
        return "Car is driving with engine: " . $this->engine;
    }
}
```

#### 3. **Public** (`public`)
- Accessible from anywhere
- No access restrictions
- Default visibility if not specified

```php
class Calculator {
    public $result = 0;  // Accessible everywhere
    
    public function add($number) {
        $this->result += $number;
        return $this;
    }
}
```

### Getters and Setters

Encapsulation often uses getter and setter methods to control access to private properties:

```php
class Product {
    private $price;
    private $name;
    
    public function __construct($name, $price) {
        $this->setName($name);
        $this->setPrice($price);
    }
    
    // Getter methods
    public function getPrice() {
        return $this->price;
    }
    
    public function getName() {
        return $this->name;
    }
    
    // Setter methods with validation
    public function setPrice($price) {
        if ($price < 0) {
            throw new InvalidArgumentException("Price cannot be negative");
        }
        $this->price = $price;
    }
    
    public function setName($name) {
        if (empty(trim($name))) {
            throw new InvalidArgumentException("Name cannot be empty");
        }
        $this->name = trim($name);
    }
    
    // Method that uses private data
    public function getDiscountedPrice($discountPercent) {
        if ($discountPercent < 0 || $discountPercent > 100) {
            throw new InvalidArgumentException("Invalid discount percentage");
        }
        return $this->price * (1 - $discountPercent / 100);
    }
}
```

### Benefits of Encapsulation

1. **Data Protection**: Prevents unauthorized access and modification
2. **Validation**: Control data integrity through setter methods
3. **Maintainability**: Internal implementation can change without affecting external code
4. **Debugging**: Easier to track where data is modified

## Abstraction

**Definition**: Abstraction hides complex implementation details and exposes only the essential features of an object. It focuses on what an object does rather than how it does it.

### Abstract Classes

Abstract classes cannot be instantiated and often contain abstract methods that must be implemented by child classes:

```php
abstract class DatabaseConnection {
    protected $host;
    protected $database;
    protected $connection;
    
    public function __construct($host, $database) {
        $this->host = $host;
        $this->database = $database;
    }
    
    // Abstract methods - must be implemented by child classes
    abstract public function connect();
    abstract public function query($sql);
    abstract public function close();
    
    // Concrete method - shared by all implementations
    public function getConnectionInfo() {
        return "Host: {$this->host}, Database: {$this->database}";
    }
    
    // Protected method for common functionality
    protected function logError($message) {
        error_log("Database Error: " . $message);
    }
}

class MySQLConnection extends DatabaseConnection {
    public function connect() {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->database}",
                $username, $password
            );
            return true;
        } catch (PDOException $e) {
            $this->logError($e->getMessage());
            return false;
        }
    }
    
    public function query($sql) {
        if (!$this->connection) {
            throw new Exception("Not connected to database");
        }
        return $this->connection->query($sql);
    }
    
    public function close() {
        $this->connection = null;
    }
}

class PostgreSQLConnection extends DatabaseConnection {
    public function connect() {
        // Different implementation for PostgreSQL
        try {
            $this->connection = new PDO(
                "pgsql:host={$this->host};dbname={$this->database}",
                $username, $password
            );
            return true;
        } catch (PDOException $e) {
            $this->logError($e->getMessage());
            return false;
        }
    }
    
    public function query($sql) {
        // PostgreSQL-specific query handling
        if (!$this->connection) {
            throw new Exception("Not connected to database");
        }
        return $this->connection->query($sql);
    }
    
    public function close() {
        $this->connection = null;
    }
}
```

### Interfaces

Interfaces define contracts that implementing classes must follow:

```php
interface PaymentProcessorInterface {
    public function processPayment($amount);
    public function refund($transactionId);
    public function getTransactionStatus($transactionId);
}

interface NotificationInterface {
    public function send($recipient, $message);
}

class CreditCardProcessor implements PaymentProcessorInterface, NotificationInterface {
    private $apiKey;
    private $gateway;
    
    public function __construct($apiKey, $gateway) {
        $this->apiKey = $apiKey;
        $this->gateway = $gateway;
    }
    
    public function processPayment($amount) {
        // Credit card specific implementation
        $transactionId = $this->gateway->charge($amount, $this->apiKey);
        $this->send("admin@example.com", "Payment processed: $amount");
        return $transactionId;
    }
    
    public function refund($transactionId) {
        return $this->gateway->refund($transactionId, $this->apiKey);
    }
    
    public function getTransactionStatus($transactionId) {
        return $this->gateway->getStatus($transactionId, $this->apiKey);
    }
    
    public function send($recipient, $message) {
        // Email notification implementation
        mail($recipient, "Payment Notification", $message);
    }
}

class PayPalProcessor implements PaymentProcessorInterface {
    private $clientId;
    private $clientSecret;
    
    public function processPayment($amount) {
        // PayPal specific implementation
        // Different from credit card but same interface
    }
    
    public function refund($transactionId) {
        // PayPal refund implementation
    }
    
    public function getTransactionStatus($transactionId) {
        // PayPal status check implementation
    }
}
```

## Practical Examples

### Example 1: E-commerce System

```php
abstract class Product {
    protected $id;
    protected $name;
    protected $price;
    protected $stock;
    
    public function __construct($id, $name, $price, $stock) {
        $this->id = $id;
        $this->name = $name;
        $this->setPrice($price);
        $this->setStock($stock);
    }
    
    // Encapsulated setters with validation
    protected function setPrice($price) {
        if ($price < 0) {
            throw new InvalidArgumentException("Price cannot be negative");
        }
        $this->price = $price;
    }
    
    protected function setStock($stock) {
        if ($stock < 0) {
            throw new InvalidArgumentException("Stock cannot be negative");
        }
        $this->stock = $stock;
    }
    
    // Abstract method - different for each product type
    abstract public function calculateShipping($destination);
    abstract public function getProductDetails();
    
    // Concrete methods shared by all products
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getPrice() { return $this->price; }
    public function getStock() { return $this->stock; }
    
    public function reduceStock($quantity) {
        if ($quantity > $this->stock) {
            throw new Exception("Insufficient stock");
        }
        $this->stock -= $quantity;
    }
}

class PhysicalProduct extends Product {
    private $weight;
    private $dimensions;
    
    public function __construct($id, $name, $price, $stock, $weight, $dimensions) {
        parent::__construct($id, $name, $price, $stock);
        $this->weight = $weight;
        $this->dimensions = $dimensions;
    }
    
    public function calculateShipping($destination) {
        // Shipping based on weight and dimensions
        $baseRate = 5.00;
        $weightRate = $this->weight * 0.50;
        return $baseRate + $weightRate;
    }
    
    public function getProductDetails() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
            'type' => 'physical'
        ];
    }
}

class DigitalProduct extends Product {
    private $downloadUrl;
    private $fileSize;
    
    public function calculateShipping($destination) {
        return 0; // No shipping for digital products
    }
    
    public function getProductDetails() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'fileSize' => $this->fileSize,
            'type' => 'digital'
        ];
    }
    
    public function getDownloadUrl() {
        return $this->downloadUrl;
    }
}
```

### Example 2: File System Abstraction

```php
interface FileStorageInterface {
    public function store($filename, $content);
    public function retrieve($filename);
    public function delete($filename);
    public function exists($filename);
}

class LocalFileStorage implements FileStorageInterface {
    private $basePath;
    
    public function __construct($basePath) {
        $this->basePath = rtrim($basePath, '/');
        if (!is_dir($this->basePath)) {
            mkdir($this->basePath, 0755, true);
        }
    }
    
    public function store($filename, $content) {
        $filepath = $this->getFilePath($filename);
        return file_put_contents($filepath, $content) !== false;
    }
    
    public function retrieve($filename) {
        $filepath = $this->getFilePath($filename);
        if (!$this->exists($filename)) {
            throw new Exception("File not found: $filename");
        }
        return file_get_contents($filepath);
    }
    
    public function delete($filename) {
        $filepath = $this->getFilePath($filename);
        return unlink($filepath);
    }
    
    public function exists($filename) {
        return file_exists($this->getFilePath($filename));
    }
    
    private function getFilePath($filename) {
        return $this->basePath . '/' . $filename;
    }
}

class CloudFileStorage implements FileStorageInterface {
    private $apiKey;
    private $bucket;
    
    public function store($filename, $content) {
        // Implementation for cloud storage (AWS S3, etc.)
    }
    
    public function retrieve($filename) {
        // Cloud retrieval implementation
    }
    
    public function delete($filename) {
        // Cloud deletion implementation
    }
    
    public function exists($filename) {
        // Cloud existence check implementation
    }
}

// Usage - client code doesn't need to know implementation details
class DocumentManager {
    private $storage;
    
    public function __construct(FileStorageInterface $storage) {
        $this->storage = $storage;
    }
    
    public function saveDocument($name, $content) {
        if ($this->storage->exists($name)) {
            throw new Exception("Document already exists");
        }
        return $this->storage->store($name, $content);
    }
    
    public function getDocument($name) {
        return $this->storage->retrieve($name);
    }
}
```

## Best Practices

### Encapsulation Best Practices

1. **Make properties private by default**
2. **Use getters/setters for controlled access**
3. **Validate data in setters**
4. **Keep internal methods private**
5. **Minimize public interface**

```php
class BankAccount {
    private $balance;
    private $accountNumber;
    private $transactions = [];
    
    public function __construct($accountNumber, $initialBalance = 0) {
        $this->accountNumber = $accountNumber;
        $this->setBalance($initialBalance);
    }
    
    public function deposit($amount) {
        $this->validateAmount($amount);
        $this->balance += $amount;
        $this->recordTransaction('deposit', $amount);
        return $this;
    }
    
    public function withdraw($amount) {
        $this->validateAmount($amount);
        if ($amount > $this->balance) {
            throw new Exception("Insufficient funds");
        }
        $this->balance -= $amount;
        $this->recordTransaction('withdrawal', $amount);
        return $this;
    }
    
    public function getBalance() {
        return $this->balance;
    }
    
    public function getTransactionHistory() {
        return array_slice($this->transactions, -10); // Last 10 transactions
    }
    
    private function validateAmount($amount) {
        if (!is_numeric($amount) || $amount <= 0) {
            throw new InvalidArgumentException("Amount must be positive number");
        }
    }
    
    private function setBalance($balance) {
        $this->validateAmount($balance);
        $this->balance = $balance;
    }
    
    private function recordTransaction($type, $amount) {
        $this->transactions[] = [
            'type' => $type,
            'amount' => $amount,
            'timestamp' => date('Y-m-d H:i:s'),
            'balance' => $this->balance
        ];
    }
}
```

### Abstraction Best Practices

1. **Use interfaces for contracts**
2. **Abstract classes for shared implementation**
3. **Keep abstractions simple and focused**
4. **Follow Liskov Substitution Principle**

## Common Mistakes

### Encapsulation Mistakes

1. **Making everything public**
```php
// ❌ BAD
class User {
    public $password; // Direct access to sensitive data
    public $email;
}

// ✅ GOOD
class User {
    private $password;
    private $email;
    
    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }
}
```

2. **No validation in setters**
```php
// ❌ BAD
public function setAge($age) {
    $this->age = $age; // No validation
}

// ✅ GOOD
public function setAge($age) {
    if (!is_int($age) || $age < 0 || $age > 150) {
        throw new InvalidArgumentException("Invalid age");
    }
    $this->age = $age;
}
```

### Abstraction Mistakes

1. **Over-abstracting**
```php
// ❌ BAD - Too many levels of abstraction
abstract class Animal {
    abstract public function move();
}
abstract class Mammal extends Animal {
    abstract public function breathe();
}
abstract class LandMammal extends Mammal {
    abstract public function walk();
}

// ✅ GOOD - Appropriate level of abstraction
abstract class Animal {
    abstract public function move();
    abstract public function makeSound();
}
```

2. **Leaky abstractions**
```php
// ❌ BAD - Implementation details leak through
interface DatabaseInterface {
    public function executeMySQLQuery($sql); // Specific to MySQL
}

// ✅ GOOD - Generic interface
interface DatabaseInterface {
    public function query($sql);
    public function insert($table, $data);
    public function update($table, $data, $conditions);
}
```

## Summary

| Concept | Purpose | Key Features | When to Use |
|---------|---------|--------------|-------------|
| **Encapsulation** | Data hiding and protection | Private/Protected properties, Getters/Setters, Validation | Always - fundamental OOP principle |
| **Abstraction** | Hide complexity, show essentials | Abstract classes, Interfaces, Polymorphism | When you need multiple implementations of similar functionality |

Both concepts work together to create maintainable, secure, and flexible PHP applications.