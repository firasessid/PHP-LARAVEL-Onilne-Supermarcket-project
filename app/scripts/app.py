from flask import Flask, jsonify
from flask_cors import CORS  # Import CORS
import pandas as pd
from sqlalchemy import create_engine
from sklearn.ensemble import RandomForestRegressor
from sklearn.model_selection import train_test_split
import numpy as np
from datetime import timedelta

app = Flask(__name__)

# Enable CORS for all routes (you can restrict it to specific origins if needed)
CORS(app, origins=["http://127.0.0.1:8001"])

# Database configuration
DB_USER = "root"
DB_PASSWORD = ""
DB_HOST = "127.0.0.1"
DB_PORT = "3306"
DB_NAME = "myproject"

db_url = f"mysql+pymysql://{DB_USER}:{DB_PASSWORD}@{DB_HOST}:{DB_PORT}/{DB_NAME}"
engine = create_engine(db_url)

# Global variable for storing the trained models
rf_model = None

def train_random_forest_model():
    # Fetch data from SQL for the last 3 months dynamically based on current day
    query = """
    SELECT 
        YEAR(o.shipped_date) AS year,
        MONTH(o.shipped_date) AS month,
        oi.product_id,
        SUM(oi.total) AS sales
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    WHERE o.shipped_date IS NOT NULL AND o.status = 'delivered'
        AND o.shipped_date >= CURDATE() - INTERVAL 3 MONTH  -- Last 3 months from current date
    GROUP BY YEAR(o.shipped_date), MONTH(o.shipped_date), oi.product_id
    ORDER BY year, month, oi.product_id
    """

    try:
        data = pd.read_sql(query, engine)

        if data.empty:
            raise ValueError("No data available for Random Forest training. Check your database.")

        # Convert date into a numerical value for machine learning
        data['date_ordinal'] = pd.to_datetime(data['year'].astype(str) + '-' + data['month'].astype(str) + '-01').map(lambda x: x.toordinal())

        # Train a model per product
        product_models = {}
        for product_id in data['product_id'].unique():
            product_data = data[data['product_id'] == product_id]

            if len(product_data) < 2:  # Ensure there are enough samples for training
                print(f"Skipping product {product_id} due to insufficient data.")
                continue  # Skip products with insufficient data

            X = product_data[['date_ordinal']]
            y = product_data['sales']

            X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

            # Train Random Forest Model
            model = RandomForestRegressor(n_estimators=100, random_state=42)
            model.fit(X_train, y_train)

            product_models[product_id] = model

        return product_models
    except Exception as e:
        print(f"Error in training model: {e}")
        return None

@app.route('/forecast', methods=['GET'])
def forecast():
    try:
        if not rf_model:
            print("Model is not trained or failed to initialize.")
            return jsonify({"error": "Model is not trained or failed to initialize"}), 500

        # Get the current date and calculate the next month's date (add 30 days)
        current_date = pd.to_datetime('now')
        next_month_date = current_date + timedelta(days=30)
        next_month_name = next_month_date.strftime('%B')

        # Generate predictions for the next month
        future_date = next_month_date.toordinal()

        predictions = {}
        for product_id, model in rf_model.items():
            try:
                # Ensure the input for prediction has the feature name
                future_date_df = pd.DataFrame([[future_date]], columns=['date_ordinal'])
                prediction = model.predict(future_date_df)[0]
                predictions[product_id] = prediction
            except Exception as e:
                print(f"Error predicting for product {product_id}: {e}")

        # Fetch product details (name and image)
        product_details_query = """
        SELECT id AS product_id, name AS product_name, image AS product_image
        FROM products
        """
        try:
            product_details = pd.read_sql(product_details_query, engine)
        except Exception as e:
            print(f"Error fetching product details: {e}")
            return jsonify({"error": "Failed to fetch product details"}), 500

        # Fetch current quantities from the products table
        current_quantity_query = """
        SELECT id AS product_id, quantity AS current_quantity
        FROM products
        """
        try:
            current_quantities = pd.read_sql(current_quantity_query, engine)
        except Exception as e:
            print(f"Error fetching current quantities: {e}")
            return jsonify({"error": "Failed to fetch current quantities"}), 500

        # Fetch monthly sales (quantity) for the current month
        current_month_sales_query = """
        SELECT oi.product_id, SUM(oi.qty) AS monthly_sales
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.id
        WHERE o.shipped_date >= DATE_FORMAT(CURDATE(), '%%Y-%%m-01')
          AND o.shipped_date < DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH, '%%Y-%%m-01')
        GROUP BY oi.product_id
        """
        try:
            monthly_sales = pd.read_sql(current_month_sales_query, engine)
        except Exception as e:
            print(f"Error fetching current month sales: {e}")
            return jsonify({"error": "Failed to fetch current month sales"}), 500

        # Fetch total sales (quantity) for all time
        total_sales_query = """
        SELECT oi.product_id, SUM(oi.qty) AS total_sales
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.id
        GROUP BY oi.product_id
        """
        try:
            total_sales = pd.read_sql(total_sales_query, engine)
        except Exception as e:
            print(f"Error fetching total sales: {e}")
            return jsonify({"error": "Failed to fetch total sales"}), 500

        # Merge predictions with product details, current quantities, monthly sales, and total sales
        results = []
        safety_buffer_percentage = 0.2  # 20% safety buffer
        prediction_cap_multiplier = 2  # Maximum multiplier for total sales

        for product_id, predicted_sales in predictions.items():
            try:
                # Get product details (name and image)
                product_row = product_details[product_details['product_id'] == product_id]
                product_name = product_row['product_name'].values[0] if not product_row.empty else "Unknown"
                product_image = product_row['product_image'].values[0] if not product_row.empty else ""

                current_quantity_row = current_quantities[current_quantities['product_id'] == product_id]
                current_quantity = current_quantity_row['current_quantity'].values[0] if not current_quantity_row.empty else 0

                monthly_sales_row = monthly_sales[monthly_sales['product_id'] == product_id]
                monthly_sales_qty = monthly_sales_row['monthly_sales'].values[0] if not monthly_sales_row.empty else 0

                total_sales_row = total_sales[total_sales['product_id'] == product_id]
                total_sales_qty = total_sales_row['total_sales'].values[0] if not total_sales_row.empty else 0

                capped_predicted_sales = min(predicted_sales, total_sales_qty * prediction_cap_multiplier)

                safety_buffer = capped_predicted_sales * safety_buffer_percentage

                recommended_quantity = max(0, (capped_predicted_sales + safety_buffer) - current_quantity)

                results.append({
                    "product_id": int(product_id),
                    "product_name": product_name,
                    "product_image": product_image,
                    "next_month": next_month_name,
                    "predicted_sales": int(round(capped_predicted_sales)),
                    "current_quantity": int(current_quantity),
                    "recommended_quantity": int(round(recommended_quantity)),
                    "monthly_sales": int(monthly_sales_qty),
                    "total_sales": int(total_sales_qty)
                })
            except Exception as e:
                print(f"Error processing product {product_id}: {e}")

        return jsonify(results)

    except Exception as e:
        print(f"Forecast error: {e}")
        return jsonify({"error": "Could not generate forecast"}), 500

if __name__ == '__main__':
    # Train the model when the app starts
    rf_model = train_random_forest_model()
    
    if rf_model is None:
        print("Error: Model could not be trained.")
    else:
        print("Model trained successfully.")
    
    # Run the Flask app
    app.run(port=8000, debug=True)
