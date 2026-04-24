# Veikals — PHP Store App

A lightweight customer management app built with vanilla PHP and MySQLi. No frameworks, no Composer — just PHP.

---

## Funkcionalitāte (Features)

- View all customers in a paginated card grid
- Search customers by name or email
- Sort customers by name or email
- Add new customers via a form
- Delete customers (blocked if they have orders)
- View all customers with their full order history at `?with-orders=full`
- Flash messages for success and error feedback

---

## Struktūra (Project Structure)

```
php_store/
├── public/
│   └── index.php               # Front controller — handles all routing
├── src/
│   ├── controllers/
│   │   └── CustomerController.php  # Handles HTTP logic for /customers
│   ├── models/
│   │   └── Customer.php            # Database queries for customers & orders
│   └── views/
│       └── (reserved for future views)
├── views/
│   ├── layout.php              # HTML shell, styles, header, footer
│   └── customers.php           # Customer list & orders HTML
├── db/
│   └── DB.php                  # MySQLi connection wrapper
├── config.php                  # Optional config (currently unused)
├── .gitignore
└── README.md
```

---

## Uzstādīšana (Setup)

### 1. Klonē projektu

```bash
git clone <repo-url>
cd php_store
```

### 2. Izveido datubāzi

```sql
CREATE DATABASE store_dev;
USE store_dev;

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    email VARCHAR(150),
    birth_date DATE,
    points INT DEFAULT 0
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    order_date DATE,
    status VARCHAR(50),
    comment TEXT,
    delivery_date DATE,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);
```

### 3. Konfigurē datubāzes savienojumu

Atver `db/DB.php` un nomainī savienojuma parametrus:

```php
self::$pdo = new mysqli('127.0.0.1', 'lietotājs', 'parole', 'store_dev');
```

### 4. Palaid serveri

```bash
php -S 127.0.0.1:8000 -t public/
```

### 5. Atver pārlūkā

```
http://127.0.0.1:8000/customers
```

---

## Maršruti (Routes)

| Metode | URL | Apraksts |
|--------|-----|----------|
| GET | `/customers` | Klientu saraksts |
| GET | `/customers?with-orders=full` | Klienti ar pasūtījumiem |
| GET | `/customers?q=anna` | Meklēšana |
| GET | `/customers?sort=email` | Kārtošana |
| POST | `/customers/add` | Pievienot klientu |
| GET | `/customers/delete?id=1` | Dzēst klientu |
