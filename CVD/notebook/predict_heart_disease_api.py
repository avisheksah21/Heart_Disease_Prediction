import numpy as np
import tensorflow as tf
import pickle
from flask import Flask, request, jsonify
from sklearn.preprocessing import StandardScaler
import os
from joblib import load
import pandas as pd
from tensorflow.keras.models import load_model

app = Flask(__name__)

MODEL_PATHS = {
    'CNN': 'models/computer_cnn_model.keras',
    'Transformer': 'models/computer_transformer_model.keras',
    'LGBMClassifier': 'models/lgbm_model.pkl',
    'Tuned Transformer': 'models/kaggle_best_cnn_tuned_model.keras',
}
SCALER_PATH = 'models/scaler.pkl'

# Define the expected feature names
expected_features = [
    'age', 'sex', 'chest_pain_type', 'resting_blood_pressure', 'cholesterol',
    'fasting_blood_sugar', 'resting_electrocardiogram', 'max_heart_rate_achieved',
    'exercise_induced_angina', 'st_depression', 'st_slope', 'num_major_vessels', 'thalassemia'
]

# Load scaler only when needed
scaler = None
def load_scaler():
    global scaler
    if scaler is None:
        if not os.path.exists(SCALER_PATH):
            raise FileNotFoundError(f"Scaler file not found at {SCALER_PATH}")
        try:
            with open(SCALER_PATH, 'rb') as f:
                scaler = pickle.load(f)
            print("Scaler loaded successfully!")
        except Exception as e:
            raise RuntimeError(f"Failed to load scaler: {str(e)}")
    return scaler

models = {}
def load_model(model_name):
    if model_name not in models:
        if not os.path.exists(MODEL_PATHS[model_name]):
            raise FileNotFoundError(f"Model file not found at {MODEL_PATHS[model_name]}")
        try:
            models[model_name] = tf.keras.models.load_model(MODEL_PATHS[model_name])
            print(f"{model_name} loaded successfully!")
        except Exception as e:
            raise RuntimeError(f"Failed to load {model_name}: {str(e)}")
    return models[model_name]

def preprocess_input(input_data, model_name):
    scaler = load_scaler()
    input_data = np.array(input_data)
    if input_data.ndim == 1:
        input_data = input_data.reshape(1, -1)
    if input_data.shape[1] != 13:
        raise ValueError(f"Expected 13 features, got {input_data.shape[1]}")
    input_scaled = scaler.transform(input_data)
    input_reshaped = input_scaled.reshape(input_scaled.shape[0], input_scaled.shape[1], 1)
    return input_reshaped

def lgbmpredict_heart_disease(input_data):
    try:
        model = load('models/lgbm_model.pkl')
        input_data = pd.DataFrame([input_data], columns=expected_features)
        probabilities = model.predict_proba(input_data)[:, 1]
        predictions = model.predict(input_data)
        return probabilities, predictions
    except Exception as e:
        raise RuntimeError(f"Prediction failed for LGBM: {str(e)}")



def predict_heart_disease(input_data, model_name):
    try:
        model = load_model(model_name)
        input_processed = preprocess_input(input_data, model_name)

        # Set threshold based on model_name
        threshold = 0.3 if model_name == 'Transformer' else 0.5

        probabilities = model.predict(input_processed, verbose=0).flatten()
        predictions = (probabilities > threshold).astype(int)
        
        return probabilities, predictions
    except Exception as e:
        raise RuntimeError(f"Prediction failed for {model_name}: {str(e)}")

@app.route('/predict', methods=['POST'])
def predict():
    try:
        data = request.get_json()
        if not data or 'input' not in data or 'model' not in data:
            return jsonify({'error': 'Missing input or model parameter'}), 400
        
        input_data = data['input']
        model_name = data['model']
        
        if model_name not in MODEL_PATHS:
            return jsonify({'error': f"Invalid model. Choose from {list(MODEL_PATHS.keys())}"}), 400
        
        if not isinstance(input_data, list) or len(input_data) != 13:
            return jsonify({'error': 'Input must be a list with 13 features'}), 400
        
        if model_name == 'LGBMClassifier':
             probs, preds = lgbmpredict_heart_disease(input_data)
             result = {
                'probability': float(probs[0]),
                'prediction': 'Heart Disease' if preds[0] == 1 else 'No Heart Disease',
                'model': model_name
            }
        else:
            probs, preds = predict_heart_disease(input_data, model_name)
            result = {
                'probability': float(probs[0]),
                'prediction': 'Heart Disease' if preds[0] == 1 else 'No Heart Disease',
                'model': model_name
            }
        
        return jsonify(result), 200
    
    except Exception as e:
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)