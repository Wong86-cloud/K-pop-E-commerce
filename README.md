🛒 K-pop E-commerce (Final Year Project)
📌 Overview

This project is a full-cycle K-pop e-commerce platform built as my Final Year Project. It demonstrates the entire online shopping journey for K-pop fans, including product browsing, cart management, order placement, order tracking, and customer reviews.

The project is powered by a custom SQL database (kpop_ecommerce.sql), ensuring structured management of users, products, orders, and reviews.

✨ Features

🏠 Homepage – Showcases promotions and featured albums/merch

🔍 Product Browsing – Search and filter K-pop albums, lightsticks, and other items

🛒 Shopping Cart & Checkout – Add/remove products and simulate order checkout

📦 Order Tracking – Track shipping and delivery status

⭐ Review System – Submit product ratings and feedback after purchase

👤 User Accounts – Registration, login, and profile management

🛠️ Tech Stack

Frontend: React / Next.js / Tailwind CSS (adjust to what you used)

Backend: Node.js / Express.js (or PHP/Laravel, depending on your actual stack)

Database: MySQL (via kpop_ecommerce.sql)

Authentication: Basic login system (username/password)

Deployment: Localhost (development) / optional deployment on Vercel/Heroku

🚀 Installation & Setup
1. Clone the repository
git clone https://github.com/yourusername/kpop-ecommerce.git
cd kpop-ecommerce

2. Import the database

Open phpMyAdmin or MySQL CLI

Create a new database (e.g., kpop_ecommerce)

Import the provided kpop_ecommerce.sql file

CREATE DATABASE kpop_ecommerce;
USE kpop_ecommerce;
SOURCE ./database/kpop_ecommerce.sql;

3. Configure environment (if needed)

Create a .env file and set database credentials:

DB_HOST=localhost
DB_USER=root
DB_PASS=your_password
DB_NAME=kpop_ecommerce


(Skip Stripe or API keys since this project uses only local SQL.)

4. Install dependencies
npm install

5. Start the server
npm run dev


Visit: http://localhost:3000

📸 Screenshots

(Add images of your homepage, cart, checkout, and order tracking here.)

🔮 Future Improvements

Add secure password hashing & JWT authentication

Real payment gateway integration (Stripe/PayPal)

Admin dashboard for managing products and orders

AI-powered recommendation system for K-pop merch

👩‍💻 Author

Zi Hao Wong

📧 Email: zhwong8806@gmail.com

🔗 LinkedIn: www.linkedin.com/in/zi-hao-wong-814242328
