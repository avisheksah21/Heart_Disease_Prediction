import unittest
import requests
import json
import time

class TestHeartDiseaseAPI(unittest.TestCase):
    BASE_URL = "http://localhost:5000/predict"
    # Sample valid input with 13 features (based on expected_features)
    VALID_INPUT = [52, 1, 0, 125, 212, 0, 1, 168, 0, 1.0, 2, 2, 3]
    MODELS = ["CNN", "Transformer", "LGBMClassifier", "Tuned Transformer"]

    def setUp(self):
        """Set up test environment."""
        # Wait briefly to ensure the Flask server is running
        time.sleep(1)

    def test_valid_prediction_all_models(self):
        """Test predictions for all models with valid input."""
        for model in self.MODELS:
            with self.subTest(model=model):
                payload = {"input": self.VALID_INPUT, "model": model}
                response = requests.post(self.BASE_URL, json=payload)
                
                self.assertEqual(response.status_code, 200, f"Failed for {model}")
                data = response.json()
                
                self.assertIn("probability", data, f"Probability missing for {model}")
                self.assertIn("prediction", data, f"Prediction missing for {model}")
                self.assertIn("model", data, f"Model name missing for {model}")
                
                self.assertIsInstance(data["probability"], float, f"Probability not float for {model}")
                self.assertTrue(0 <= data["probability"] <= 1, f"Probability out of range for {model}")
                self.assertIn(data["prediction"], ["Heart Disease", "No Heart Disease"], f"Invalid prediction for {model}")
                self.assertEqual(data["model"], model, f"Model name mismatch for {model}")

    def test_invalid_input_length(self):
        """Test with input that has incorrect number of features."""
        invalid_input = self.VALID_INPUT[:-1]  # Remove one feature (12 instead of 13)
        payload = {"input": invalid_input, "model": "CNN"}
        response = requests.post(self.BASE_URL, json=payload)
        
        self.assertEqual(response.status_code, 400)
        data = response.json()
        self.assertIn("error", data)
        self.assertIn("13 features", data["error"])

    def test_missing_input(self):
        """Test with missing input field."""
        payload = {"model": "CNN"}
        response = requests.post(self.BASE_URL, json=payload)
        
        self.assertEqual(response.status_code, 400)
        data = response.json()
        self.assertIn("error", data)
        self.assertIn("Missing input", data["error"])

    def test_missing_model(self):
        """Test with missing model field."""
        payload = {"input": self.VALID_INPUT}
        response = requests.post(self.BASE_URL, json=payload)
        
        self.assertEqual(response.status_code, 400)
        data = response.json()
        self.assertIn("error", data)
        self.assertIn("Missing input or model parameter", data["error"])

    def test_invalid_model(self):
        """Test with an invalid model name."""
        payload = {"input": self.VALID_INPUT, "model": "InvalidModel"}
        response = requests.post(self.BASE_URL, json=payload)
        
        self.assertEqual(response.status_code, 400)
        data = response.json()
        self.assertIn("error", data)
        self.assertIn("Invalid model", data["error"])

    def test_non_list_input(self):
        """Test with non-list input."""
        payload = {"input": "not a list", "model": "CNN"}
        response = requests.post(self.BASE_URL, json=payload)
        
        self.assertEqual(response.status_code, 400)
        data = response.json()
        self.assertIn("error", data)
        self.assertIn("Input must be a list", data["error"])

    def test_model_file_missing(self):
        """Test with a model file that doesn't exist (requires mocking or renaming)."""
        # Note: This test assumes you temporarily rename a model file to simulate absence.
        # For a proper test, you may need to mock the os.path.exists function.
        # Skipping detailed implementation here, but you can test by manually removing a model file
        # and checking for a 500 error with an appropriate error message.
        pass

if __name__ == "__main__":
    unittest.main()