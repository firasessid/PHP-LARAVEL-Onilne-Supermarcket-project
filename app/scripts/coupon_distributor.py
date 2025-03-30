import json
import sys
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
from sklearn.preprocessing import StandardScaler
import base64

class CouponDistributor:
    # ... (le reste de votre classe)

    def predict(self, user_data):
        scaled_data = self.scaler.transform([[
            user_data['age'],
            user_data['purchase_frequency'],
            user_data['avg_spending'],
            user_data['points']
        ]])
        prediction = self.model.predict(scaled_data)[0]
        # Supposons que 'prediction' corresponde à l'ID du coupon
        return {'coupon_id': int(prediction)}

if __name__ == "__main__":
    if len(sys.argv) > 1 and sys.argv[1] == 'predict':
        user_data = json.loads(base64.b64decode(sys.argv[2]).decode('utf-8'))
        distributor = CouponDistributor()
        distributor.train('chemin/vers/entrainement.csv')  # Mettez à jour le chemin
        result = distributor.predict(user_data)
        print(json.dumps(result))