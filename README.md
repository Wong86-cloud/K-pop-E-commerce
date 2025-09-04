# 🛒 K-pop E-commerce (Final Year Project)  

## 📌 Overview  
This project is a **K-pop e-commerce platform** developed as my Final Year Project.  
It aims to provide K-pop fans with an engaging online shopping experience that covers every step of the customer journey.  

From browsing albums and merchandise to completing purchases, tracking orders, and leaving reviews, the system demonstrates a practical implementation of **UI/UX design, backend logic, and SQL database management**.  

The backend is powered by a **custom SQL database (`kpop_ecommerce.sql`)**, which ensures efficient and structured handling of users, products, orders, and reviews.  

---

## ✨ Features  

- 🏠 **Homepage**  
  Showcases featured products, promotions, and newly released albums to engage users immediately.  

- 🔍 **Product Browsing**  
  Users can browse albums, lightsticks, and other K-pop merchandise with options to filter and search.  

- 🛒 **Shopping Cart & Checkout**  
  Add/remove items from the cart and simulate the checkout process. This includes order confirmation and saving order details into the database.  

- 📦 **Order Tracking**  
  Customers can check the status of their orders (e.g., Processing, Shipped, Delivered).  

- ⭐ **Review System**  
  After receiving products, users can leave ratings and reviews, which are stored in the database and displayed on product pages.  

- 👤 **User Accounts**  
  Users can register, log in, and manage their profiles. Login details are validated through the SQL database.  

---

## 🛠️ Tech Stack  

- **Frontend**: React.js / Next.js with Tailwind CSS for responsive UI  
- **Backend**: Node.js with PHP
- **Database**: MySQL (imported from `kpop_ecommerce.sql`)  
- **Authentication**: Basic login and session handling  
- **Deployment**: Runs locally (development). Can be deployed using platforms like Vercel or Heroku in the future.  

---

## 🚀 Installation & Setup  

### 1. Clone the repository  
First, download the project source code to your computer. You can do this by cloning the GitHub repository using the following command:  
```bash
git clone https://github.com/yourusername/kpop-ecommerce.git
cd kpop-ecommerce

---
2. Set up the database

This project uses a MySQL database. A preconfigured SQL file (kpop_ecommerce.sql) is included to make setup easier.

Open phpMyAdmin or your MySQL command line tool.

Create a new database named kpop_ecommerce:

CREATE DATABASE kpop_ecommerce;


Import the provided SQL file into the database:

USE kpop_ecommerce;
SOURCE ./database/kpop_ecommerce.sql;


After completing this step, your database will contain all required tables such as users, products, orders, and reviews.

3. Configure environment variables

Next, create a file named .env in the root directory of the project.
This file will store your local database connection details. For example:

DB_HOST=localhost
DB_USER=root
DB_PASS=your_password
DB_NAME=kpop_ecommerce


Replace your_password with your actual MySQL root password (or leave it empty if you don’t have one).

4. Install project dependencies

The project requires Node.js packages to run. Install all dependencies by running:

npm install


This will download and set up all the required libraries listed in the package.json file.

5. Start the development server

Finally, launch the development server with:

npm run dev


Once the server is running, open your browser and go to:

👉 http://localhost:3000
