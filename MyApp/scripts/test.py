import unittest
from auto_run import calculate_time_difference, should_run_main

class TestAutoRun(unittest.TestCase):
    def test_calculate_time_difference(self):
        # Define escenarios de prueba
        end_time = datetime.datetime(2023, 10, 4, 4, 35, 10, 892814)
        current_time = datetime.datetime(2023, 10, 4, 5, 5, 54, 671030)

        # Llama a la función que deseas probar
        time_difference = calculate_time_difference(current_time, end_time)

        # Comprueba si el resultado es el esperado
        self.assertAlmostEqual(time_difference, 30.72963693333333, places=5)

    def test_should_run_main(self):
        # Define escenarios de prueba
        time_difference_large = 10
        time_difference_small = 2

        # Llama a la función que deseas probar
        run_main_large = should_run_main(time_difference_large)
        run_main_small = should_run_main(time_difference_small)

        # Comprueba si la función decide correctamente si ejecutar main.py
        self.assertTrue(run_main_large)
        self.assertFalse(run_main_small)

if __name__ == "__main__":
    unittest.main()
