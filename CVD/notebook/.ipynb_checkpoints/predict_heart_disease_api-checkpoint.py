import numpy as np
import tensorflow as tf
import pickle
from flask import Flask, request, jsonify
from sklearn.preprocessing import StandardScaler

app = Flask(__name__)

MODEL_PATHS = {
    'CNN': 'models/computer_cnn_model.keras',
    'Transformer': 'models/computer_transformer_model.keras',
    'LGBMClassifier': 'models/lgbm_model.pkl',
    'Tuned Transformer': 'models/kaggle_best_cnn_tuned_model.keras'
}
SCALER_PATH = 'models/scaler.pkl'

with open(SCALER_PATH, 'rb') as f:
    scaler = pickle.load(f)
print("Scaler loaded successfully!")

models = {}
def load_model(model_name):
    if model_name not in models:
        if model_name == 'LGBMClassifier':
            with open(MODEL_PATHS[model_name], 'rb') as f:
                models[model_name] = pickle.load(f)
            print(f"{model_name} loaded successfully!")
        else:
            models[model_name] = tf.keras.models.load_model(MODEL_PATHS[model_name])
            print(f"{model_name} loaded successfully!")
    return models[model_name]
    
def preprocess_input(input_data, model_name):
    input_data = np.array(input_data)
    if input_data.ndim == 1:
        input_data = input_data.reshape(1, -1)
    if input_data.shape[1] != 13:
        raise ValueError(f"Expected 13 features, got {input_data.shape[1]}")

    input_scaled = scaler.transform(input_data)
    if model_name in ['CNN', 'Transformer', 'Tuned Transformer']:
        input_reshaped = input_scaled.reshape(input_scaled.shape[0], input_scaled.shape[1], 1)
        return input_reshaped
    return input_scaled
    
def predict_heart_disease(input_data, model_name):
    model = load_model(model_name)
    input_processed = preprocess_input(input_data, model_name)
    if model_name == 'LGBMClassifier':
        probabilities = model.predict_proba(input_processed)[:, 1]
        predictions = (probabilities > 0.5).astype(int)
    else:
        probabilities = model.predict(input_processed, verbose=0).flatten()
        predictions = (probabilities > 0.5).astype(int)
    
    return probabilities, predictions
    
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
        probs, preds = predict_heart_disease(input_data, model_name)
        result = {
            'probability': float(probs[0]),
            'prediction': 'Heart Disease' if preds[0] == 1 else 'No Heart Disease',
            'model': model_name
        }
        
        return jsonify(result), 200
    
    except Exception as e:ai
        return jsonify({'error': str(e)}), 500
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)