import pandas as pd
from sqlalchemy import create_engine
from datetime import datetime, timedelta
import json

DB_URI = "mysql+mysqlconnector://root:@127.0.0.1:3306/myproject"

def fetch_sales_data():
    """Fetch sales data from order_items"""
    engine = create_engine(DB_URI)
    
    today = datetime.now().replace(hour=0, minute=0, second=0, microsecond=0)
    last_month_end = (today.replace(day=1) - timedelta(days=1))
    last_month_start = last_month_end.replace(day=1)
    previous_month_end = last_month_start - timedelta(days=1)
    previous_month_start = previous_month_end.replace(day=1)

    query = f"""
        SELECT 
            oi.product_id,
            p.name as product_name,
            p.image as product_image,
            SUM(oi.qty) as total_quantity,
            SUM(oi.qty * oi.price) as revenue,
            DATE(o.created_at) as order_date
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        JOIN orders o ON oi.order_id = o.id
        WHERE o.created_at BETWEEN '{previous_month_start}' AND '{last_month_end}'
        GROUP BY oi.product_id, DATE(o.created_at)
    """

    try:
        df = pd.read_sql(query, engine)
        return df, last_month_start, last_month_end, previous_month_start, previous_month_end
    except Exception as e:
        print(f"Database error: {str(e)}")
        return pd.DataFrame(), None, None, None, None
    finally:
        engine.dispose()

def calculate_regression():
    """Calculate month-over-month regression"""
    sales_df, last_month_start, last_month_end, previous_month_start, previous_month_end = fetch_sales_data()
    
    if sales_df.empty:
        return {"error": "No sales data available"}

    sales_df['month'] = pd.to_datetime(sales_df['order_date']).dt.to_period('M')
    monthly_sales = sales_df.groupby(['product_id', 'month'])['revenue'].sum().unstack().reset_index()
    
    months = sorted(monthly_sales.columns[1:], reverse=True)[:2]
    
    results = []
    for _, row in monthly_sales.iterrows():
        product_data = {
            "product_id": row['product_id'],
            "last_month_revenue": row.get(months[0], 0),
            "previous_month_revenue": row.get(months[1], 0),
            "last_month_range": [
                last_month_start.strftime('%Y-%m-%d'),
                last_month_end.strftime('%Y-%m-%d')
            ],
            "previous_month_range": [
                previous_month_start.strftime('%Y-%m-%d'),
                previous_month_end.strftime('%Y-%m-%d')
            ]
        }
        
        try:
            change = product_data["last_month_revenue"] - product_data["previous_month_revenue"]
            product_data["regression_percentage"] = (change / product_data["previous_month_revenue"]) * 100
        except ZeroDivisionError:
            product_data["regression_percentage"] = 0 if change == 0 else 100
        
        product_details = sales_df[sales_df['product_id'] == row['product_id']].iloc[0]
        product_data.update({
            "product_name": product_details['product_name'],
            "product_image": product_details['product_image']
        })
        
        results.append(product_data)

    return {
        "regression_results": results,
        "summaries": "Monthly sales regression analysis completed"
    }

if __name__ == "__main__":
    results = calculate_regression()
    print(json.dumps(results))