# Countrypedia

Countrypedia is a Laravel-based country encyclopedia web application. This README provides simple instructions to get started, run migrations, and work with Docker using Laravel Sail.

## Prerequisites

- [Docker](https://www.docker.com/) & [Docker Compose](https://docs.docker.com/compose/)
- PHP 8.0+ (for local CLI use, if needed)
- Git

## Getting Started

1. **Clone the Repository**

```bash
   git clone git@github.com:jbumaniss/countrypedia.git
   cd countrypedia
```

2. **Configure the Environment**

   Copy the `.env.example` file to `.env`:

```bash
   cp .env.example .env
```

3. **Start Laravel Sail**

```bash
   cp .env.example .env
```
4. **Install Dependencies**

   If you are using Laravel Sail, run the following command to install dependencies:

```bash
   ./vendor/bin/sail composer install
```

5. **Run Migrations**

   To set up the database, run the migrations:

```bash
   ./vendor/bin/sail artisan migrate
```

6. **Access the Application**

   Open your web browser and navigate to `http://localhost`.


## Testing

### Run Tests

```bash
   ./vendor/bin/sail test
```

### Run Tests with Specific Filter

```bash
   ./vendor/bin/sail test --filter=SomeTest
```

### Run Tests with Coverage

```bash
   ./vendor/bin/sail test --coverage --coverage-filter=src/App
   ./vendor/bin/sail test --coverage --coverage-filter=src/Domain
```

## Miscellaneous

```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```