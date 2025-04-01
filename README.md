[Rapport_PFE_Essid_Firas.pdf](https://github.com/user-attachments/files/19543080/Rapport_PFE_Essid_Firas.pdf)
Supernet.Shop
Supernet.Shop is a cutting-edge, full-featured online platform designed specifically for supermarkets and grocery stores, enabling them to easily manage and sell a variety of products including fruits, vegetables, meats, dairy, and more. The platform provides an intuitive, user-friendly experience for both administrators and customers, making it the go-to solution for modern e-commerce in the supermarket industry.

Key Features
User-Friendly Interface: A modern, clean, and responsive design that ensures a smooth shopping experience for customers across devices.

Product Management: Easy-to-use tools for administrators to manage product catalogs, categories, brands, prices, and stock levels.

Shopping Cart & Checkout: Secure and efficient shopping cart system with seamless checkout process, integrated payment gateways (e.g., Stripe) for real-time transactions.

Order Tracking: Real-time tracking of customer orders with detailed status updates.

Promotions & Coupons: A robust promotions system for offering discounts, coupons, and special deals to customers.

Dynamic Recommendations: Personalized product recommendations based on customer browsing and purchasing behavior.

Multi-Language Support: Language options that provide a global reach for customers, ensuring accessibility across regions.

Secure Authentication & Authorization: Safe and reliable user authentication using industry-standard practices such as JWT and OAuth.

Admin Dashboard & Analytics: A powerful admin dashboard that provides insightful data analysis for decision-making and business optimization.

Technologies Used
Back-End: Laravel 10 PHP framework, ensuring a stable and scalable backend architecture.

Front-End: A responsive front-end built using modern JavaScript frameworks to ensure a smooth user experience.

Database: MySQL/MariaDB for high-performance, relational database management.

Payment Integration: Stripe for seamless payment processing and handling.

Security: SSL encryption, OAuth2, and JWT for secure user authentication and authorization.

Deployment: Hosted on AWS EC2 with database on AWS RDS for reliability and scalability.

Installation
To set up Supernet.Shop locally:

Clone the repository:

bash
Copy
Edit
git clone https://github.com/firasessid/PHP-LARAVEL-Onilne-Supermarcket-project
cd supernet-shop
Install dependencies:

bash
Copy
Edit
composer install
npm install
Set up the .env file:

bash
Copy
Edit
cp .env.example .env
Configure the database and other environment settings in .env.

Run migrations:

bash
Copy
Edit
php artisan migrate
Set up storage link:

bash
Copy
Edit
php artisan storage:link
Start the local development server:

bash
Copy
Edit
php artisan serve
Contributing
We welcome contributions! If you have suggestions, bug fixes, or new features to propose, please fork the repository, create a branch, and submit a pull request.
