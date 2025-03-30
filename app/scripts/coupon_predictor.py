import json
import sys
from sklearn.ensemble import RandomForestClassifier
from sklearn.preprocessing import StandardScaler
import pandas as pd
import base64

class CouponPredictor:
    def __init__(self):
        self.model = RandomForestClassifier()
        self.scaler = StandardScaler()
    
    def train(self, data_path):
        df = pd.read_csv(data_path)
        X = self.scaler.fit_transform(df[['loyalty_points', 'purchase_frequency', 'avg_spending', 'age']])
        y = df['coupon_id']
        self.model.fit(X, y)
    
    def predict(self, features):  # Correction: 4 espaces d'indentation
        # Conversion en DataFrame avec les noms de colonnes
        X_pred = pd.DataFrame([[
            features['loyalty_points'],
            features['purchase_frequency'],
            features['avg_spending'],
            features['age']
        ]], columns=['loyalty_points', 'purchase_frequency', 'avg_spending', 'age'])
        
        scaled = self.scaler.transform(X_pred)
        return {'coupon_id': int(self.model.predict(scaled)[0])}

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Usage: python coupon_predictor.py [train|predict] [data]")
        sys.exit(1)
    
    if sys.argv[1] == 'predict':
        # Chargement du modèle entraîné
        predictor = CouponPredictor()
        predictor.train('C:/stage2024/stage1/stage/storage/data/coupon_training_data.csv')
        
        # Prédiction
        features = json.loads(base64.b64decode(sys.argv[2]).decode('utf-8'))
        result = predictor.predict(features)
        print(json.dumps(result))