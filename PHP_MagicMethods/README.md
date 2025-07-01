# Interfaces e Polymorfismo in PHP

## Cos'è un'Interface?

Un'**interface** è un contratto che definisce quali metodi una classe deve implementare, senza specificarne il comportamento. È come un blueprint che garantisce che le classi che la implementano abbiano determinati metodi.

### Caratteristiche delle Interfaces:
- Contengono solo dichiarazioni di metodi (senza implementazione)
- Tutti i metodi sono implicitamente `public`
- Non possono contenere proprietà (eccetto costanti)
- Una classe può implementare multiple interfaces
- Si usa la keyword `implements`

## Esempio Base di Interface

```php
<?php
interface VehicleInterface
{
    public function start();
    public function stop();
    public function getSpeed();
}

class Car implements VehicleInterface
{
    private $speed = 0;
    
    public function start()
    {
        echo "Auto avviata\n";
    }
    
    public function stop()
    {
        $this->speed = 0;
        echo "Auto fermata\n";
    }
    
    public function getSpeed()
    {
        return $this->speed;
    }
}

class Motorcycle implements VehicleInterface
{
    private $speed = 0;
    
    public function start()
    {
        echo "Moto avviata\n";
    }
    
    public function stop()
    {
        $this->speed = 0;
        echo "Moto fermata\n";
    }
    
    public function getSpeed()
    {
        return $this->speed;
    }
}
?>
```

## Cos'è il Polymorfismo?

Il **polymorfismo** è la capacità di oggetti di classi diverse di essere trattati allo stesso modo attraverso un'interfaccia comune. Permette di scrivere codice più flessibile e riutilizzabile.

### Tipi di Polymorfismo in PHP:
1. **Interface Polymorphism** - oggetti che implementano la stessa interface
2. **Inheritance Polymorphism** - oggetti che ereditano dalla stessa classe base

## Esempio di Polymorfismo con Interfaces

```php
<?php
// Interface per animali
interface AnimalInterface
{
    public function makeSound();
    public function move();
}

// Implementazioni concrete
class Dog implements AnimalInterface
{
    public function makeSound()
    {
        return "Woof!";
    }
    
    public function move()
    {
        return "Corre";
    }
}

class Cat implements AnimalInterface
{
    public function makeSound()
    {
        return "Meow!";
    }
    
    public function move()
    {
        return "Cammina silenziosamente";
    }
}

class Bird implements AnimalInterface
{
    public function makeSound()
    {
        return "Tweet!";
    }
    
    public function move()
    {
        return "Vola";
    }
}

// Funzione che usa il polymorfismo
function animalAction(AnimalInterface $animal)
{
    echo "L'animale dice: " . $animal->makeSound() . "\n";
    echo "L'animale: " . $animal->move() . "\n";
    echo "---\n";
}

// Utilizzo
$animals = [
    new Dog(),
    new Cat(),
    new Bird()
];

foreach ($animals as $animal) {
    animalAction($animal); // Stesso metodo, comportamenti diversi!
}
?>
```

## Esempio Avanzato: Sistema di Pagamento

```php
<?php
interface PaymentInterface
{
    public function processPayment(float $amount): bool;
    public function getPaymentMethod(): string;
}

class CreditCardPayment implements PaymentInterface
{
    private $cardNumber;
    
    public function __construct(string $cardNumber)
    {
        $this->cardNumber = $cardNumber;
    }
    
    public function processPayment(float $amount): bool
    {
        // Logica per processare pagamento con carta
        echo "Processando €{$amount} con carta {$this->cardNumber}\n";
        return true;
    }
    
    public function getPaymentMethod(): string
    {
        return "Carta di Credito";
    }
}

class PayPalPayment implements PaymentInterface
{
    private $email;
    
    public function __construct(string $email)
    {
        $this->email = $email;
    }
    
    public function processPayment(float $amount): bool
    {
        // Logica per processare pagamento PayPal
        echo "Processando €{$amount} con PayPal ({$this->email})\n";
        return true;
    }
    
    public function getPaymentMethod(): string
    {
        return "PayPal";
    }
}

class BankTransferPayment implements PaymentInterface
{
    private $iban;
    
    public function __construct(string $iban)
    {
        $this->iban = $iban;
    }
    
    public function processPayment(float $amount): bool
    {
        // Logica per bonifico bancario
        echo "Processando €{$amount} con bonifico a {$this->iban}\n";
        return true;
    }
    
    public function getPaymentMethod(): string
    {
        return "Bonifico Bancario";
    }
}

// Classe che gestisce i pagamenti
class PaymentProcessor
{
    public function executePayment(PaymentInterface $payment, float $amount)
    {
        echo "Metodo di pagamento: " . $payment->getPaymentMethod() . "\n";
        
        if ($payment->processPayment($amount)) {
            echo "Pagamento completato con successo!\n";
        } else {
            echo "Errore nel pagamento!\n";
        }
        echo "---\n";
    }
}

// Utilizzo
$processor = new PaymentProcessor();

$payments = [
    new CreditCardPayment("**** **** **** 1234"),
    new PayPalPayment("user@example.com"),
    new BankTransferPayment("IT60 X054 2811 1010 0000 0123 456")
];

foreach ($payments as $payment) {
    $processor->executePayment($payment, 99.99);
}
?>
```

## Vantaggi delle Interfaces e del Polymorfismo

### 1. **Flessibilità**
- Facile aggiungere nuove implementazioni senza modificare il codice esistente

### 2. **Testabilità**
- Permette di creare mock objects per i test

### 3. **Manutenibilità**
- Codice più pulito e organizzato

### 4. **Riusabilità**
- Stesso codice può lavorare con oggetti diversi

## Interface vs Abstract Class

| Interface | Abstract Class |
|-----------|----------------|
| Solo dichiarazioni di metodi | Può avere metodi implementati |
| Multiple inheritance | Single inheritance |
| Solo costanti | Proprietà normali |
| Tutti i metodi public | Metodi di diversa visibilità |

## Best Practices

1. **Naming Convention**: Suffisso `Interface` (es. `PaymentInterface`)
2. **Piccole e specifiche**: Un'interface dovrebbe avere un singolo scopo
3. **Documenta bene**: Specifica il comportamento atteso nei commenti
4. **Type Hinting**: Usa sempre le interfaces nei parametri delle funzioni

```php
// ✅ Buono
function processPayment(PaymentInterface $payment) { }

// ❌ Evita
function processPayment($payment) { }
```

## Esercizio Pratico

Prova a creare:
1. Un'interface `ShapeInterface` con metodi `calculateArea()` e `calculatePerimeter()`
2. Implementa le classi `Circle`, `Rectangle`, `Triangle`
3. Crea una funzione che calcola l'area totale di un array di forme