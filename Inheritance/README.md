# Inheritance in PHP OOP

## Table of Contents
1. [What is Inheritance](#what-is-inheritance)
2. [Types of Inheritance](#types-of-inheritance)
3. [Method Overriding](#method-overriding)
4. [Parent Keyword](#parent-keyword)
5. [Final Keyword](#final-keyword)
6. [Practical Examples](#practical-examples)
7. [Best Practices](#best-practices)
8. [Common Mistakes](#common-mistakes)

## What is Inheritance

**Definition**: Inheritance is a fundamental OOP principle that allows a class (child/derived class) to inherit properties and methods from another class (parent/base class). This promotes code reuse and establishes a hierarchical relationship between classes.

### Basic Inheritance Syntax

```php
class ParentClass {
    protected $property;
    
    public function method() {
        return "Parent method";
    }
}

class ChildClass extends ParentClass {
    // Inherits $property and method() from ParentClass
    
    public function childMethod() {
        return "Child method";
    }
}

// Usage
$child = new ChildClass();
echo $child->method();      // "Parent method" - inherited
echo $child->childMethod(); // "Child method" - own method
```

### Key Concepts

1. **Parent Class (Base/Super Class)**: The class being inherited from
2. **Child Class (Derived/Sub Class)**: The class that inherits
3. **`extends` keyword**: Used to establish inheritance relationship
4. **Inherited members**: Properties and methods accessible in child class

## Types of Inheritance

### 1. Single Inheritance
PHP supports single inheritance - a class can extend only one parent class.

```php
class Vehicle {
    protected $brand;
    protected $model;
    protected $year;
    
    public function __construct($brand, $model, $year) {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
    }
    
    public function getInfo() {
        return "{$this->year} {$this->brand} {$this->model}";
    }
    
    public function start() {
        return "Vehicle started";
    }
    
    public function stop() {
        return "Vehicle stopped";
    }
}

class Car extends Vehicle {
    private $doors;
    private $transmission;
    
    public function __construct($brand, $model, $year, $doors, $transmission) {
        parent::__construct($brand, $model, $year); // Call parent constructor
        $this->doors = $doors;
        $this->transmission = $transmission;
    }
    
    public function getCarDetails() {
        return $this->getInfo() . " - {$this->doors} doors, {$this->transmission}";
    }
    
    public function honk() {
        return "Beep beep!";
    }
}

// Usage
$car = new Car("Toyota", "Camry", 2023, 4, "Automatic");
echo $car->getCarDetails(); // "2023 Toyota Camry - 4 doors, Automatic"
echo $car->start();         // "Vehicle started" - inherited method
echo $car->honk();          // "Beep beep!" - own method
```

### 2. Multilevel Inheritance
A chain of inheritance where a child class becomes a parent for another class.

```php
class Vehicle {
    protected $brand;
    
    public function start() {
        return "Vehicle starting...";
    }
}

class Car extends Vehicle {
    protected $doors;
    
    public function drive() {
        return "Car is driving";
    }
}

class SportsCar extends Car {
    private $topSpeed;
    
    public function __construct($brand, $doors, $topSpeed) {
        $this->brand = $brand;      // From Vehicle
        $this->doors = $doors;      // From Car
        $this->topSpeed = $topSpeed;
    }
    
    public function turboBoost() {
        return "Turbo activated! Top speed: {$this->topSpeed} mph";
    }
    
    public function getDetails() {
        return "Sports car: {$this->brand}, {$this->doors} doors";
    }
}

$sportsCar = new SportsCar("Ferrari", 2, 200);
echo $sportsCar->start();      // From Vehicle
echo $sportsCar->drive();      // From Car
echo $sportsCar->turboBoost(); // Own method
```

### 3. Hierarchical Inheritance
Multiple child classes inherit from the same parent class.

```php
class Animal {
    protected $name;
    protected $species;
    
    public function __construct($name, $species) {
        $this->name = $name;
        $this->species = $species;
    }
    
    public function eat() {
        return "{$this->name} is eating";
    }
    
    public function sleep() {
        return "{$this->name} is sleeping";
    }
    
    public function getInfo() {
        return "Name: {$this->name}, Species: {$this->species}";
    }
}

class Dog extends Animal {
    private $breed;
    
    public function __construct($name, $breed) {
        parent::__construct($name, "Canine");
        $this->breed = $breed;
    }
    
    public function bark() {
        return "{$this->name} says: Woof! Woof!";
    }
    
    public function fetch() {
        return "{$this->name} is fetching the ball";
    }
}

class Cat extends Animal {
    private $indoor;
    
    public function __construct($name, $indoor = true) {
        parent::__construct($name, "Feline");
        $this->indoor = $indoor;
    }
    
    public function meow() {
        return "{$this->name} says: Meow!";
    }
    
    public function climb() {
        return "{$this->name} is climbing";
    }
}

class Bird extends Animal {
    private $canFly;
    
    public function __construct($name, $canFly = true) {
        parent::__construct($name, "Avian");
        $this->canFly = $canFly;
    }
    
    public function chirp() {
        return "{$this->name} says: Tweet tweet!";
    }
    
    public function fly() {
        if ($this->canFly) {
            return "{$this->name} is flying";
        }
        return "{$this->name} cannot fly";
    }
}

// Usage
$dog = new Dog("Buddy", "Golden Retriever");
$cat = new Cat("Whiskers");
$bird = new Bird("Tweety");

echo $dog->bark();    // "Buddy says: Woof! Woof!"
echo $cat->meow();    // "Whiskers says: Meow!"
echo $bird->chirp();  // "Tweety says: Tweet tweet!"

// All inherit from Animal
echo $dog->eat();     // "Buddy is eating"
echo $cat->sleep();   // "Whiskers is sleeping"
echo $bird->getInfo(); // "Name: Tweety, Species: Avian"
```

## Method Overriding

Child classes can override parent methods to provide their own implementation.

```php
class Shape {
    protected $color;
    
    public function __construct($color) {
        $this->color = $color;
    }
    
    public function getColor() {
        return $this->color;
    }
    
    public function getArea() {
        return "Area calculation not implemented";
    }
    
    public function getPerimeter() {
        return "Perimeter calculation not implemented";
    }
    
    public function getDescription() {
        return "A {$this->color} shape";
    }
}

class Circle extends Shape {
    private $radius;
    
    public function __construct($color, $radius) {
        parent::__construct($color);
        $this->radius = $radius;
    }
    
    // Override parent method
    public function getArea() {
        return pi() * pow($this->radius, 2);
    }
    
    // Override parent method
    public function getPerimeter() {
        return 2 * pi() * $this->radius;
    }
    
    // Override parent method
    public function getDescription() {
        return "A {$this->color} circle with radius {$this->radius}";
    }
    
    public function getDiameter() {
        return $this->radius * 2;
    }
}

class Rectangle extends Shape {
    private $width;
    private $height;
    
    public function __construct($color, $width, $height) {
        parent::__construct($color);
        $this->width = $width;
        $this->height = $height;
    }
    
    // Override parent method
    public function getArea() {
        return $this->width * $this->height;
    }
    
    // Override parent method
    public function getPerimeter() {
        return 2 * ($this->width + $this->height);
    }
    
    // Override parent method
    public function getDescription() {
        return "A {$this->color} rectangle ({$this->width}x{$this->height})";
    }
    
    public function isSquare() {
        return $this->width === $this->height;
    }
}

// Usage
$circle = new Circle("red", 5);
$rectangle = new Rectangle("blue", 4, 6);

echo $circle->getDescription();    // "A red circle with radius 5"
echo $circle->getArea();          // 78.54 (approximately)
echo $rectangle->getDescription(); // "A blue rectangle (4x6)"
echo $rectangle->getArea();       // 24
```

## Parent Keyword

The `parent` keyword allows access to parent class methods and properties.

```php
class Employee {
    protected $name;
    protected $salary;
    protected $department;
    
    public function __construct($name, $salary, $department) {
        $this->name = $name;
        $this->salary = $salary;
        $this->department = $department;
    }
    
    public function getDetails() {
        return "Employee: {$this->name}, Salary: \${$this->salary}, Department: {$this->department}";
    }
    
    public function work() {
        return "{$this->name} is working";
    }
    
    public function calculateBonus() {
        return $this->salary * 0.05; // 5% bonus
    }
}

class Manager extends Employee {
    private $teamSize;
    private $projects;
    
    public function __construct($name, $salary, $department, $teamSize) {
        parent::__construct($name, $salary, $department); // Call parent constructor
        $this->teamSize = $teamSize;
        $this->projects = [];
    }
    
    // Override parent method but use parent implementation
    public function getDetails() {
        $parentDetails = parent::getDetails(); // Get parent implementation
        return $parentDetails . ", Team Size: {$this->teamSize}, Role: Manager";
    }
    
    // Override parent method
    public function work() {
        $parentWork = parent::work(); // Call parent method
        return $parentWork . " and managing {$this->teamSize} team members";
    }
    
    // Override parent method with enhanced calculation
    public function calculateBonus() {
        $baseBonus = parent::calculateBonus(); // Get parent bonus
        $managementBonus = $this->teamSize * 500; // Additional bonus for team size
        return $baseBonus + $managementBonus;
    }
    
    public function addProject($project) {
        $this->projects[] = $project;
    }
    
    public function getProjects() {
        return $this->projects;
    }
}

class Developer extends Employee {
    private $programmingLanguages;
    private $experienceYears;
    
    public function __construct($name, $salary, $department, $languages, $experience) {
        parent::__construct($name, $salary, $department);
        $this->programmingLanguages = $languages;
        $this->experienceYears = $experience;
    }
    
    public function getDetails() {
        $parentDetails = parent::getDetails();
        $languages = implode(", ", $this->programmingLanguages);
        return $parentDetails . ", Languages: {$languages}, Experience: {$this->experienceYears} years, Role: Developer";
    }
    
    public function work() {
        $parentWork = parent::work();
        return $parentWork . " on coding projects";
    }
    
    public function calculateBonus() {
        $baseBonus = parent::calculateBonus();
        $skillBonus = count($this->programmingLanguages) * 200; // Bonus per language
        $experienceBonus = $this->experienceYears * 100; // Bonus per year
        return $baseBonus + $skillBonus + $experienceBonus;
    }
    
    public function code($project) {
        return "{$this->name} is coding {$project}";
    }
}

// Usage
$manager = new Manager("Alice Johnson", 80000, "IT", 5);
$developer = new Developer("Bob Smith", 70000, "IT", ["PHP", "JavaScript", "Python"], 3);

echo $manager->getDetails();
// "Employee: Alice Johnson, Salary: $80000, Department: IT, Team Size: 5, Role: Manager"

echo $developer->getDetails();
// "Employee: Bob Smith, Salary: $70000, Department: IT, Languages: PHP, JavaScript, Python, Experience: 3 years, Role: Developer"

echo $manager->work();
// "Alice Johnson is working and managing 5 team members"

echo $developer->work();
// "Bob Smith is working on coding projects"

echo "Manager bonus: $" . $manager->calculateBonus();  // Base + team bonus
echo "Developer bonus: $" . $developer->calculateBonus(); // Base + skill + experience bonus
```

## Final Keyword

The `final` keyword prevents inheritance of classes or overriding of methods.

### Final Classes

```php
final class DatabaseConnection {
    private $connection;
    
    public function connect($host, $database, $username, $password) {
        $this->connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    }
    
    public function query($sql) {
        return $this->connection->query($sql);
    }
}

// This will cause a fatal error
// class ExtendedConnection extends DatabaseConnection {} // Error!
```

### Final Methods

```php
class User {
    protected $id;
    protected $username;
    protected $email;
    
    public function __construct($id, $username, $email) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
    }
    
    // This method cannot be overridden
    final public function getId() {
        return $this->id;
    }
    
    // This method can be overridden
    public function getDisplayName() {
        return $this->username;
    }
    
    // This method cannot be overridden
    final protected function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

class AdminUser extends User {
    private $permissions;
    
    public function __construct($id, $username, $email, $permissions) {
        parent::__construct($id, $username, $email);
        $this->permissions = $permissions;
    }
    
    // This is allowed - method is not final
    public function getDisplayName() {
        return "Admin: " . $this->username;
    }
    
    // This would cause an error - method is final
    // public function getId() { return "ADMIN_" . $this->id; } // Error!
    
    public function getPermissions() {
        return $this->permissions;
    }
}
```

## Practical Examples

### Example 1: Content Management System

```php
abstract class Content {
    protected $id;
    protected $title;
    protected $author;
    protected $createdAt;
    protected $updatedAt;
    protected $status;
    
    public function __construct($id, $title, $author) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->status = 'draft';
    }
    
    // Getters
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getAuthor() { return $this->author; }
    public function getCreatedAt() { return $this->createdAt; }
    public function getUpdatedAt() { return $this->updatedAt; }
    public function getStatus() { return $this->status; }
    
    // Common methods
    public function publish() {
        $this->status = 'published';
        $this->updatedAt = new DateTime();
    }
    
    public function unpublish() {
        $this->status = 'unpublished';
        $this->updatedAt = new DateTime();
    }
    
    public function updateTitle($title) {
        $this->title = $title;
        $this->updatedAt = new DateTime();
    }
    
    // Abstract methods - must be implemented by child classes
    abstract public function getContentPreview();
    abstract public function getFullContent();
    abstract public function getContentType();
    abstract public function validate();
}

class Article extends Content {
    private $body;
    private $tags;
    private $category;
    private $readTime;
    
    public function __construct($id, $title, $author, $body, $category) {
        parent::__construct($id, $title, $author);
        $this->body = $body;
        $this->category = $category;
        $this->tags = [];
        $this->calculateReadTime();
    }
    
    public function getBody() { return $this->body; }
    public function getCategory() { return $this->category; }
    public function getTags() { return $this->tags; }
    public function getReadTime() { return $this->readTime; }
    
    public function updateBody($body) {
        $this->body = $body;
        $this->calculateReadTime();
        $this->updatedAt = new DateTime();
    }
    
    public function addTag($tag) {
        if (!in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }
    }
    
    public function removeTag($tag) {
        $this->tags = array_filter($this->tags, function($t) use ($tag) {
            return $t !== $tag;
        });
    }
    
    // Implement abstract methods
    public function getContentPreview() {
        return substr(strip_tags($this->body), 0, 150) . '...';
    }
    
    public function getFullContent() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'body' => $this->body,
            'category' => $this->category,
            'tags' => $this->tags,
            'readTime' => $this->readTime,
            'status' => $this->status,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s')
        ];
    }
    
    public function getContentType() {
        return 'article';
    }
    
    public function validate() {
        $errors = [];
        
        if (empty($this->title)) {
            $errors[] = 'Title is required';
        }
        
        if (empty($this->body)) {
            $errors[] = 'Body is required';
        }
        
        if (strlen($this->body) < 100) {
            $errors[] = 'Article body must be at least 100 characters';
        }
        
        if (empty($this->category)) {
            $errors[] = 'Category is required';
        }
        
        return $errors;
    }
    
    private function calculateReadTime() {
        $wordCount = str_word_count(strip_tags($this->body));
        $this->readTime = ceil($wordCount / 200); // 200 words per minute
    }
}

class Video extends Content {
    private $videoUrl;
    private $duration; // in seconds
    private $thumbnail;
    private $description;
    
    public function __construct($id, $title, $author, $videoUrl, $duration) {
        parent::__construct($id, $title, $author);
        $this->videoUrl = $videoUrl;
        $this->duration = $duration;
        $this->description = '';
    }
    
    public function getVideoUrl() { return $this->videoUrl; }
    public function getDuration() { return $this->duration; }
    public function getThumbnail() { return $this->thumbnail; }
    public function getDescription() { return $this->description; }
    
    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
        $this->updatedAt = new DateTime();
    }
    
    public function setDescription($description) {
        $this->description = $description;
        $this->updatedAt = new DateTime();
    }
    
    public function getDurationFormatted() {
        $hours = floor($this->duration / 3600);
        $minutes = floor(($this->duration % 3600) / 60);
        $seconds = $this->duration % 60;
        
        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }
        return sprintf('%02d:%02d', $minutes, $seconds);
    }
    
    // Implement abstract methods
    public function getContentPreview() {
        $preview = "Video: {$this->title} ({$this->getDurationFormatted()})";
        if (!empty($this->description)) {
            $preview .= " - " . substr($this->description, 0, 100) . '...';
        }
        return $preview;
    }
    
    public function getFullContent() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'videoUrl' => $this->videoUrl,
            'duration' => $this->duration,
            'durationFormatted' => $this->getDurationFormatted(),
            'thumbnail' => $this->thumbnail,
            'description' => $this->description,
            'status' => $this->status,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s')
        ];
    }
    
    public function getContentType() {
        return 'video';
    }
    
    public function validate() {
        $errors = [];
        
        if (empty($this->title)) {
            $errors[] = 'Title is required';
        }
        
        if (empty($this->videoUrl)) {
            $errors[] = 'Video URL is required';
        }
        
        if (!filter_var($this->videoUrl, FILTER_VALIDATE_URL)) {
            $errors[] = 'Invalid video URL';
        }
        
        if ($this->duration <= 0) {
            $errors[] = 'Duration must be greater than 0';
        }
        
        return $errors;
    }
}

class Podcast extends Content {
    private $audioUrl;
    private $duration; // in seconds
    private $episodeNumber;
    private $series;
    private $transcript;
    
    public function __construct($id, $title, $author, $audioUrl, $duration, $episodeNumber, $series) {
        parent::__construct($id, $title, $author);
        $this->audioUrl = $audioUrl;
        $this->duration = $duration;
        $this->episodeNumber = $episodeNumber;
        $this->series = $series;
        $this->transcript = '';
    }
    
    public function getAudioUrl() { return $this->audioUrl; }
    public function getDuration() { return $this->duration; }
    public function getEpisodeNumber() { return $this->episodeNumber; }
    public function getSeries() { return $this->series; }
    public function getTranscript() { return $this->transcript; }
    
    public function setTranscript($transcript) {
        $this->transcript = $transcript;
        $this->updatedAt = new DateTime();
    }
    
    public function getDurationFormatted() {
        $hours = floor($this->duration / 3600);
        $minutes = floor(($this->duration % 3600) / 60);
        $seconds = $this->duration % 60;
        
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
    
    // Implement abstract methods
    public function getContentPreview() {
        return "Podcast: {$this->series} - Episode {$this->episodeNumber}: {$this->title} ({$this->getDurationFormatted()})";
    }
    
    public function getFullContent() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'audioUrl' => $this->audioUrl,
            'duration' => $this->duration,
            'durationFormatted' => $this->getDurationFormatted(),
            'episodeNumber' => $this->episodeNumber,
            'series' => $this->series,
            'transcript' => $this->transcript,
            'status' => $this->status,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s')
        ];
    }
    
    public function getContentType() {
        return 'podcast';
    }
    
    public function validate() {
        $errors = [];
        
        if (empty($this->title)) {
            $errors[] = 'Title is required';
        }
        
        if (empty($this->audioUrl)) {
            $errors[] = 'Audio URL is required';
        }
        
        if (!filter_var($this->audioUrl, FILTER_VALIDATE_URL)) {
            $errors[] = 'Invalid audio URL';
        }
        
        if ($this->duration <= 0) {
            $errors[] = 'Duration must be greater than 0';
        }
        
        if ($this->episodeNumber <= 0) {
            $errors[] = 'Episode number must be greater than 0';
        }
        
        if (empty($this->series)) {
            $errors[] = 'Series name is required';
        }
        
        return $errors;
    }
}

// Usage
$article = new Article(1, "Getting Started with PHP OOP", "John Doe", 
    "Object-oriented programming is a programming paradigm...", "Programming");
$article->addTag("PHP");
$article->addTag("OOP");
$article->addTag("Programming");

$video = new Video(2, "PHP OOP Tutorial", "Jane Smith", 
    "https://example.com/video.mp4", 1800); // 30 minutes
$video->setDescription("Complete tutorial on PHP OOP concepts");

$podcast = new Podcast(3, "The Future of PHP", "Tech Talk", 
    "https://example.com/audio.mp3", 2700, 15, "PHP Weekly"); // 45 minutes

// All content types can be treated polymorphically
$contents = [$article, $video, $podcast];

foreach ($contents as $content) {
    echo "Type: " . $content->getContentType() . "\n";
    echo "Preview: " . $content->getContentPreview() . "\n";
    echo "Status: " . $content->getStatus() . "\n";
    echo "Validation: " . (empty($content->validate()) ? "Valid" : "Invalid") . "\n";
    echo "---\n";
}
```

### Example 2: Payment Processing System

```php
abstract class PaymentMethod {
    protected $amount;
    protected $currency;
    protected $transactionId;
    protected $status;
    protected $createdAt;
    
    public function __construct($amount, $currency = 'USD') {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->transactionId = $this->generateTransactionId();
        $this->status = 'pending';
        $this->createdAt = new DateTime();
    }
    
    public function getAmount() { return $this->amount; }
    public function getCurrency() { return $this->currency; }
    public function getTransactionId() { return $this->transactionId; }
    public function getStatus() { return $this->status; }
    public function getCreatedAt() { return $this->createdAt; }
    
    protected function generateTransactionId() {
        return 'TXN_' . strtoupper(uniqid());
    }
    
    protected function validateAmount() {
        if ($this->amount <= 0) {
            throw new InvalidArgumentException("Amount must be greater than 0");
        }
        if ($this->amount > 10000) {
            throw new InvalidArgumentException("Amount exceeds maximum limit");
        }
    }
    
    protected function setStatus($status) {
        $this->status = $status;
    }
    
    // Abstract methods
    abstract public function processPayment();
    abstract public function validatePaymentDetails();
    abstract public function getPaymentMethodName();
    abstract public function getTransactionFee();
}

class CreditCardPayment extends PaymentMethod {
    private $cardNumber;
    private $expiryDate;
    private $cvv;
    private $cardholderName;
    private $cardType;
    
    public function __construct($amount, $cardNumber, $expiryDate, $cvv, $cardholderName, $currency = 'USD') {
        parent::__construct($amount, $currency);
        $this->cardNumber = $this->maskCardNumber($cardNumber);
        $this->expiryDate = $expiryDate;
        $this->cvv = $cvv;
        $this->cardholderName = $cardholderName;
        $this->cardType = $this->detectCardType($cardNumber);
    }
    
    public function getCardNumber() { return $this->cardNumber; }
    public function getCardholderName() { return $this->cardholderName; }
    public function getCardType() { return $this->cardType; }
    
    public function processPayment() {
        try {
            $this->validateAmount();
            $this->validatePaymentDetails();
            
            // Simulate payment processing
            $this->setStatus('processing');
            
            // Simulate API call to payment gateway
            $success = $this->callPaymentGateway();
            
            if ($success) {
                $this->setStatus('completed');
                return [
                    'success' => true,
                    'transactionId' => $this->transactionId,
                    'message' => 'Payment processed successfully'
                ];
            } else {
                $this->setStatus('failed');
                return [
                    'success' => false,
                    'message' => 'Payment processing failed'
                ];
            }
        } catch (Exception $e) {
            $this->setStatus('failed');
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function validatePaymentDetails() {
        $errors = [];
        
        if (strlen($this->cardNumber) < 13) {
            $errors[] = 'Invalid card number';
        }
        
        if (!$this->isValidExpiryDate($this->expiryDate)) {
            $errors[] = 'Invalid or expired card';
        }
        
        if (strlen($this->cvv) < 3 || strlen($this->cvv) > 4) {
            $errors[] = 'Invalid CVV';
        }
        
        if (empty($this->cardholderName)) {
            $errors[] = 'Cardholder name is required';
        }
        
        if (!empty($errors)) {
            throw new InvalidArgumentException(implode(', ', $errors));
        }
        
        return true;
    }
    
    public function getPaymentMethodName() {
        return "Credit Card ({$this->cardType})";
    }
    
    public function getTransactionFee() {
        return $this->amount * 0.029 + 0.30; // 2.9% + $0.30
    }
    
    private function maskCardNumber($cardNumber) {
        $cleaned = preg_replace('/\D/', '', $cardNumber);
        return str_repeat('*', strlen($cleaned) - 4) . substr($cleaned, -4);
    }
    
    private function detectCardType($cardNumber) {
        $cleaned = preg_replace('/\D/', '', $cardNumber);
        
        if (preg_match('/^4/', $cleaned)) return 'Visa';
        if (preg_match('/^5[1-5]/', $cleaned)) return 'MasterCard';
        if (preg_match('/^3[47]/', $cleaned)) return 'American Express';
        if (preg_match('/^6(?:011|5)/', $cleaned)) return 'Discover';
        
        return 'Unknown';
    }
    
    private function isValidExpiryDate($expiryDate) {
        $parts = explode('/', $expiryDate);
        if (count($parts) !== 2) return false;
        
        $month = intval($parts[0]);
        $year = intval('20' . $parts[1]);
        
        if ($month < 1 || $month > 12) return false;
        
        $currentYear = intval(date('Y'));
        $currentMonth = intval(date('m'));
        
        return ($year > $currentYear) || ($year === $currentYear && $month >= $currentMonth);
    }
    
    private function callPaymentGateway() {
        // Simulate payment gateway call
        // In real implementation, this would make API calls to payment processors
        return mt_rand(0, 100) > 10; // 90% success rate
    }
}

class PayPalPayment extends PaymentMethod {
    private $email;
    private $paypalAccountId;
    
    public function __construct($amount, $email, $currency = 'USD') {
        parent::__construct($amount, $currency);
        $this->email = $email;
        $this->paypalAccountId = $this->generatePayPalId();
    }
    
    public function getEmail() { return $this->email; }
    public function getPayPalAccountId() { return $this->paypalAccountId; }
    
    public function processPayment() {
        try {
            $this->validateAmount();
            $this->validatePaymentDetails();
            
            $this->setStatus('processing');
            
            // Simulate PayPal API call
            $success = $this->callPayPalAPI();
            
            if ($success) {
                $this->setStatus('completed');
                return [
                    'success' => true,
                    'transactionId' => $this->transactionId,
                    'message' => 'PayPal payment processed successfully'
                ];
            } else {
                $this->setStatus('failed');
                return [
                    'success' => false,
                    'message' => 'PayPal payment processing failed'
                ];
            }
        } catch (Exception $e) {
            $this->setStatus('failed');
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function validatePaymentDetails() {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid PayPal email address');
        }
        return true;
    }
    
    public function getPaymentMethodName() {
        return 'PayPal';
    }
    
    public function getTransactionFee() {
        return $this->amount * 0.034 + 0.35; // 3.4% + $0.35
    }
    
    private function generatePayPalId() {
        return 'PP_' . strtoupper(uniqid());
    }
    
    private function callPayPalAPI() {
        // Simulate PayPal API call
        return mt_rand(0, 100) > 5; // 95% success rate
    }
}

class BankTransferPayment extends PaymentMethod {
    private $bankAccount;
    private $routingNumber;
    private $accountHolderName;
    private $bankName;
    
    public function __construct($amount, $bankAccount, $routingNumber, $accountHolderName, $bankName, $currency = 'USD') {
        parent::__construct($amount, $currency);
        $this->bankAccount = $this->maskAccountNumber($bankAccount);
        $this->routingNumber = $routingNumber;
        $this->accountHolderName = $accountHolderName;
        $this->bankName = $bankName;
    }
    
    public function getBankAccount() { return $this->bankAccount; }
    public function getRoutingNumber() { return $this->routingNumber; }
    public function getAccountHolderName() { return $this->accountHolderName; }
    public function getBankName() { return $this->bankName; }
    
    public function processPayment() {
        try {
            $this->validateAmount();
            $this->validatePaymentDetails();
            
            $this->setStatus('processing');
            
            // Bank transfers take longer to process
            $success = $this->initiateBankTransfer();
            
            if ($success) {
                $this->setStatus('pending_verification'); // Bank transfers need verification
                return [
                    'success' => true,
                    'transactionId' => $this->transactionId,
                    'message' => 'Bank transfer initiated. Verification required.'
                ];
            } else {
                $this->setStatus('failed');
                return [
                    'success' => false,
                    'message' => 'Bank transfer initiation failed'
                ];
            }
        } catch (Exception $e) {
            $this->setStatus('failed');
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function validatePaymentDetails() {
        $errors = [];
        
        if (strlen($this->routingNumber) !== 9) {
            $errors[] = 'Invalid routing number';
        }
        
        if (empty($this->accountHolderName)) {
            $errors[] = 'Account holder name is required';
        }
        
        if (empty($this->bankName)) {
            $errors[] = 'Bank name is required';
        }
        
        if (!empty($errors)) {
            throw new InvalidArgumentException(implode(', ', $errors));
        }
        
        return true;
    }
    
    public function getPaymentMethodName() {
        return "Bank Transfer ({$this->bankName})";
    }
    
    public function getTransactionFee() {
        return 1.50; // Flat fee for bank transfers
    }
    
    public function verifyTransfer($verificationCode) {
        // Simulate verification process
        if ($this->status === 'pending_verification') {
            if (strlen($verificationCode) === 6) {
                $this->setStatus('completed');
                return true;
            }
        }
        return false;
    }
    
    private function maskAccountNumber($accountNumber) {
        return str_repeat('*', strlen($accountNumber) - 4) . substr($accountNumber, -4);
    }
    
    private function initiateBankTransfer() {
        // Simulate bank transfer initiation
        return mt_rand(0, 100) > 2; // 98% success rate
    }
}

// Usage
$creditCard = new CreditCardPayment(100.00, '4532123456789012', '12/25', '123', 'John Doe');
$paypal = new PayPalPayment(75.50, 'user@example.com');
$bankTransfer = new BankTransferPayment(500.00, '1234567890', '123456789', 'Jane Smith', 'Chase Bank');

$payments = [$creditCard, $paypal, $bankTransfer];

foreach ($payments as $payment) {
    echo "Payment Method: " . $payment->getPaymentMethodName() . "\n";
    echo "Amount: " . $payment->getCurrency() . " " . number_format($payment->getAmount(), 2) . "\n";
    echo "Transaction Fee: " . $payment->getCurrency() . " " . number_format($payment->getTransactionFee(), 2) . "\n";
    echo "Transaction ID: " . $payment->getTransactionId() . "\n";
    
    $result = $payment->processPayment();
    echo "Result: " . ($result['success'] ? 'Success' : 'Failed') . "\n";
    echo "Message: " . $result['message'] . "\n";
    echo "Status: " . $payment->getStatus() . "\n";
    echo "---\n";
}
```

## Best Practices

### 1. Use Inheritance for "IS-A" Relationships
```php
// ✅ GOOD - Dog IS-A Animal
class Animal { /* ... */ }
class Dog extends Animal { /* ... */ }

// ❌ BAD - Car HAS-A Engine (composition, not inheritance)
class Engine { /* ... */ }
class Car extends Engine { /* ... */ } // Wrong!

// ✅ GOOD - Use composition instead
class Car {
    private $engine;
    
    public function __construct(Engine $engine) {
        $this->engine = $engine;
    }
}
```

### 2. Follow the Liskov Substitution Principle
```php
// ✅ GOOD - Child classes can replace parent without breaking functionality
class Bird {
    public function eat() { return "eating"; }
    public function makeSound() { return "chirping"; }
}

class Sparrow extends Bird {
    public function makeSound() { return "chirp chirp"; }
}

class Eagle extends Bird {
    public function makeSound() { return "screech"; }
}
```

### 3. Use Protected Instead of Private for Extensibility
```php
class BaseController {
    protected $request;  // Accessible to child classes
    private $config;     // Only for this class
    
    protected function validateInput($data) {
        // Can be overridden by child classes
    }
}
```

### 4. Don't Override Final Methods
```php
class Security {
    final public function authenticate($credentials) {
        // Critical security logic - cannot be overridden
    }
    
    public function authorize($user) {
        // Can be customized by child classes
    }
}
```

## Common Mistakes

### 1. Deep Inheritance Hierarchies
```php
// ❌ BAD - Too many levels
class Vehicle { }
class LandVehicle extends Vehicle { }
class MotorizedVehicle extends LandVehicle { }
class Car extends MotorizedVehicle { }
class SportsCar extends Car { }
class Ferrari extends SportsCar { }

// ✅ GOOD - Simpler hierarchy
class Vehicle { }
class Car extends Vehicle { }
class SportsCar extends Car { }
```

### 2. Not Calling Parent Constructor
```php
// ❌ BAD
class Child extends Parent {
    public function __construct($childParam) {
        $this->childParam = $childParam;
        // Forgot to call parent::__construct()
    }
}

// ✅ GOOD
class Child extends Parent {
    public function __construct($parentParam, $childParam) {
        parent::__construct($parentParam);
        $this->childParam = $childParam;
    }
}
```

### 3. Inappropriate Inheritance
```php
// ❌ BAD - User is not a Database
class Database {
    public function connect() { /* ... */ }
    public function query() { /* ... */ }
}

class User extends Database {
    public function getName() { /* ... */ }
}

// ✅ GOOD - Use composition
class User {
    private $database;
    
    public function __construct(Database $database) {
        $this->database = $database;
    }
    
    public function save() {
        $this->database->query(/* ... */);
    }
}
```

### 4. Breaking Parent Contract
```php
// ❌ BAD - Child changes expected behavior
class Rectangle {
    protected $width, $height;
    
    public function setWidth($width) { $this->width = $width; }
    public function setHeight($height) { $this->height = $height; }
    public function getArea() { return $this->width * $this->height; }
}

class Square extends Rectangle {
    public function setWidth($width) {
        $this->width = $this->height = $width; // Changes behavior!
    }
}

// ✅ GOOD - Consistent behavior
abstract class Shape {
    abstract public function getArea();
}

class Rectangle extends Shape {
    // Implementation specific to rectangles
}

class Square extends Shape {
    // Implementation specific to squares
}
```

## Summary

| Concept | Purpose | Key Points |
|---------|---------|------------|
| **Inheritance** | Code reuse, hierarchical relationships | `extends` keyword, single inheritance |
| **Method Overriding** | Customize parent behavior | Same method signature, different implementation |
| **Parent Keyword** | Access parent implementation | `parent::method()`, `parent::__construct()` |
| **Final Keyword** | Prevent inheritance/overriding | `final class`, `final method` |

Inheritance is a powerful tool that promotes code reuse and establishes clear relationships between classes. Use it wisely to create maintainable and extensible PHP applications.