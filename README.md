# LaraCommerce - A Laravel E-commerce API

This is the backend API for the LaraCommerce e-commerce application, built with the Laravel framework. It provides a comprehensive set of endpoints to manage products, categories, users, orders, and more. It includes features like user authentication with JWT, cart management, order processing with payment gateway integration, and image handling via Cloudinary.

## About The Application

LaraCommerce is a robust e-commerce platform that allows administrators to manage inventory and users to browse products and make purchases. The application is designed to be scalable and easy to maintain, following Laravel's best practices.

### Key Features

-   **User Authentication**: Secure user and admin registration and login using JSON Web Tokens (JWT).
-   **Product Management**: Full CRUD (Create, Read, Update, Delete) functionality for products.
-   **Category Management**: Organize products into categories with full CRUD operations.
-   **Product Variants**: Manage product variations like sizes and colors.
-   **Shopping Cart**: Persistent shopping cart functionality for authenticated users.
-   **Wishlist**: Allows users to save items for later.
-   **Order Management**: A complete system for creating, viewing, and managing orders.
-   **Payment Integration**: Integrated with Paystack for processing payments, with webhook support for real-time updates.
-   **Cloud Media Management**: Handles image uploads and transformations using Cloudinary.
-   **Debugging and Monitoring**: Integrated with Laravel Telescope for easy debugging and monitoring of requests, exceptions, and more.

## Getting Started

Follow these instructions to get a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

-   PHP >= 8.1
-   Composer
-   A database server (e.g., MySQL, PostgreSQL)
-   Node.js & NPM (for frontend asset management, if needed)

### Installation

1.  **Clone the repository**

    ```bash
    git clone https://github.com/akandeseun/laracommerce.git
    cd laracommerce
    ```

2.  **Install PHP dependencies**

    ```bash
    composer install
    ```

3.  **Create your environment file**

    ```bash
    cp .env.example .env
    ```

4.  **Generate an application key**

    ```bash
    php artisan key:generate
    ```

5.  **Generate a JWT secret key**

    ```bash
    php artisan jwt:secret
    ```

6.  **Configure your `.env` file**
    Open the `.env` file and update the following sections with your local environment details:

    -   `APP_URL`: Your local development URL (e.g., `http://localhost:8000`)
    -   `DB_*` variables: Your database connection details (`DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
    -   `CLOUDINARY_URL`: Your Cloudinary credentials.
    -   `PAYSTACK_PUBLIC_KEY` and `PAYSTACK_SECRET_KEY`: Your Paystack API keys.

7.  **Run database migrations**
    This will create all the necessary tables in your database.

    ```bash
    php artisan migrate
    ```

8.  **(Optional) Seed the database**
    This will populate your database with some dummy data to get you started.

    ```bash
    php artisan db:seed
    ```

9.  **Start the development server**
    ```bash
    php artisan serve
    ```
    The application will be available at `http://localhost:8000` (or the specified port).

## API Endpoints

Here is a list of the available API routes for the application.

| Method           | URI                           | Action                                | Middleware |
| :--------------- | :---------------------------- | :------------------------------------ | :--------- |
| **Auth**         |                               |                                       |            |
| `POST`           | `/api/register`               | Register a new user                   | `api`      |
| `POST`           | `/api/admin/register`         | Register a new admin                  | `api`      |
| `POST`           | `/api/login`                  | Login a user                          | `api`      |
| `POST`           | `/api/admin/login`            | Login an admin                        | `api`      |
| `GET`            | `/api/confirm-email`          | Confirm user's email                  | `jwt-auth` |
| `POST`           | `/api/logout`                 | Logout a user                         | `jwt-auth` |
| **Category**     |                               |                                       |            |
| `GET`            | `/api/category`               | Get all categories                    | `api`      |
| `GET`            | `/api/category/{id}`          | Get a single category                 | `api`      |
| `POST`           | `/api/category`               | Create a new category                 | `api`      |
| `PATCH`          | `/api/category`               | Update a category                     | `api`      |
| `DELETE`         | `/api/category/{id}`          | Delete a category                     | `api`      |
| **Products**     |                               |                                       |            |
| `POST`           | `/api/img`                    | Upload product image to Cloudinary    | `api`      |
| `GET`            | `/api/product`                | Get all products                      | `api`      |
| `POST`           | `/api/product`                | Create a new product                  | `api`      |
| `GET`            | `/api/product/{id}`           | Get a single product                  | `api`      |
| `PATCH`          | `/api/product/{id}`           | Update a product                      | `api`      |
| `DELETE`         | `/api/product/{id}`           | Delete a product                      | `api`      |
| **Sizes**        |                               |                                       |            |
| `GET`            | `/api/size`                   | Get all sizes                         | `api`      |
| `GET`            | `/api/size/{id}`              | Get a single size                     | `api`      |
| `POST`           | `/api/size`                   | Create a new size                     | `api`      |
| `PATCH`          | `/api/size`                   | Update a size                         | `api`      |
| `DELETE`         | `/api/size/{id}`              | Delete a size                         | `api`      |
| **Colors**       |                               |                                       |            |
| `GET`            | `/api/color`                  | Get all colors                        | `api`      |
| `GET`            | `/api/color/{id}`             | Get a single color                    | `api`      |
| `POST`           | `/api/color`                  | Create a new color                    | `api`      |
| `PATCH`          | `/api/color`                  | Update a color                        | `api`      |
| `DELETE`         | `/api/color/{id}`             | Delete a color                        | `api`      |
| **Cart**         |                               |                                       |            |
| `POST`           | `/api/cart/create`            | Create or update a user's cart        | `api`      |
| `GET`            | `/api/cart`                   | Get the current user's cart           | `jwt-auth` |
| **Wishlist**     |                               |                                       |            |
| `POST`           | `/api/wishlist/create`        | Add a product to the wishlist         | `jwt-auth` |
| `POST`           | `/api/wishlist/remove`        | Remove a product from the wishlist    | `jwt-auth` |
| `GET`            | `/api/wishlist`               | Get the current user's wishlist       | `jwt-auth` |
| **Orders**       |                               |                                       |            |
| `POST`           | `/api/order/create`           | Create a new order                    | `api`      |
| `GET`            | `/api/order`                  | Get all orders                        | `api`      |
| `GET`            | `/api/order/{idOrRef}`        | Get an order by ID or reference       | `api`      |
| `POST`           | `/api/order/{idOrRef}/status` | Update order status                   | `api`      |
| `GET`            | `/api/order/pending`          | Get all pending orders                | `api`      |
| **Webhooks**     |                               |                                       |            |
| `POST`           | `/api/paystack-webhook`       | Handle Paystack webhook notifications | `api`      |
| **Transactions** |                               |                                       |            |
| `GET`            | `/api/transactions`           | Get all transactions                  | `api`      |
| `GET`            | `/api/transactions/total`     | Get total transaction amount          | `api`      |

## Contributing

Thank you for considering contributing to the LaraCommerce project! Please feel free to create a pull request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

E-Commerce API developed with Laravel

Documentation: https://documenter.getpostman.com/view/20514882/2s9YeK2p2v