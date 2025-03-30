import sys
import json
import base64
import h2o
import pandas as pd
from h2o.estimators import H2OIsolationForestEstimator

def train_model(train_data):
    model = H2OIsolationForestEstimator(
        ntrees=100,
        max_depth=20,
        contamination=0.1,
        seed=42
    )
    features = ['login_frequency', 'time_since_last_login', 
               'ip_change_count', 'location_change', 'device_change']
    model.train(x=features, training_frame=train_data)
    return model

def analyze_data(data):
    try:
        h2o.init(ip="127.0.0.1", port=54321, strict_version_check=False)
        
        # Convertir en DataFrame H2O
        h2o_df = h2o.H2OFrame(pd.DataFrame(data))
        
        # Entraîner le modèle
        model = train_model(h2o_df)
        
        # Faire des prédictions
        predictions = model.predict(h2o_df)
        results = predictions.as_data_frame()
        
        return {
            'status': 'success',
            'is_anomalous': results['predict'].mean() > 0.65,
            'risk_score': (1 - results['predict']).mean() * 100,
            'details': results.to_dict()
        }
    except Exception as e:
        return {
            'status': 'error',
            'message': str(e)
        }
    finally:
        if h2o.cluster():
            h2o.cluster().shutdown()

def main():
    try:
        encoded_data = sys.argv[1]
        decoded_data = base64.b64decode(encoded_data).decode('utf-8')
        data = json.loads(decoded_data)
        
        result = analyze_data(data)
        print(json.dumps(result))
        
    except Exception as e:
        print(json.dumps({
            "status": "error",
            "message": f"Processing failed: {str(e)}"
        }))

if __name__ == "__main__":
    main()