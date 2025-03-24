# Laravel Real-Time Product Display

This is a Laravel-based real-time product display application that fetches products from the **Fake Store API** and updates the frontend dynamically using **Pusher** for real-time updates.

---

## **Features**
- Fetches product data from [Fake Store API](https://fakestoreapi.com/).
- Displays product name, description, price, category, image, and rating.
- Uses **Pusher** for real-time updates when a new product is added.
- Laravel event broadcasting with JavaScript (Pusher) for frontend updates.

---

## **Prerequisites**
Ensure you have the following installed:
- PHP 8.1+
- Composer
- MySQL (or any database supported by Laravel)
- Node.js & NPM
- Pusher account ([Sign up here](https://pusher.com/))

---

## **Installation Instructions**

### **1. Clone the Repository**
```sh
git clone https://github.com/your-repo/laravel-realtime-products.git
cd laravel-realtime-products
```

### **2. Install Dependencies**
```sh
composer install
npm install
```

### **3. Configure Environment Variables**
Rename `.env.example` to `.env`:
```sh
cp .env.example .env
```
Then, update the following fields in `.env`:
```env
APP_NAME=LaravelRealTimeProducts
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_app_secret
PUSHER_APP_CLUSTER=ap1  # Change based on your selected cluster
```

### **4. Run Migrations**
```sh
php artisan migrate
```

### **5. Generate Application Key**
```sh
php artisan key:generate
```

### **6. Start the Laravel Server**
```sh
php artisan serve
```

### **7. Start WebSocket Listener**
```sh
php artisan queue:work
```

### **8. Open the Application**
Visit:
```
http://127.0.0.1:8000/
```

### **9. Fetch Products from API**

```sh
php artisan fetch:products
```
Or
```sh
curl http://127.0.0.1:8000/fetch-products
```
Those command will retrieve products from Fake Store API and store them in the database.


---

## **How Real-Time Updates Work**
1. When products are fetched from the Fake Store API, they are stored in the database.
2. A Laravel event (`ProductUpdated`) is fired whenever a new product is added.
3. This event is broadcasted using **Pusher**.
4. The frontend listens for the event via **JavaScript & Pusher**, dynamically updating the product list without refreshing the page.

---

## **Testing Real-Time Updates**
1. Add a new product manually via the database.
2. Run `php artisan fetch:products` again.
3. The product list on the frontend should update instantly.

---

## **Troubleshooting**
### **1. Error: Pusher Not Working**
- Double-check your `.env` credentials for Pusher.
- Make sure you have created an app in the [Pusher dashboard](https://dashboard.pusher.com/).
- Restart the queue listener: `php artisan queue:restart`

### **2. Database Connection Issues**
- Ensure MySQL is running and `.env` has correct database credentials.
- Run migrations again: `php artisan migrate:fresh`

### **3. Products Not Showing**
- Check if the database contains products: `php artisan tinker` → `\App\Models\Product::all();`
- Ensure `php artisan fetch:products` has been run successfully.

---

## **Contributing**
Feel free to fork this project, make improvements, and submit pull requests.

---

## **License**
This project is licensed under the MIT License.

