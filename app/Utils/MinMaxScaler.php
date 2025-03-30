<?php
namespace App\Utils;

use Rubix\ML\Datasets\Unlabeled;

class MinMaxScaler
{
    private array $minValues = [];
    private array $maxValues = [];

    // Fit the scaler to the dataset and return the transformed data
    public function fitTransform(Unlabeled $dataset): Unlabeled
    {
        $samples = $dataset->samples();
        
        // Check if the dataset is empty
        if (empty($samples)) {
            throw new \InvalidArgumentException("The dataset is empty. Cannot fit the scaler.");
        }

        // Check if the first sample has features (non-empty)
        $numFeatures = count($samples[0]);
        if ($numFeatures === 0) {
            throw new \InvalidArgumentException("The dataset contains samples with no features.");
        }

        // Initialize min and max values arrays
        $this->minValues = array_fill(0, $numFeatures, PHP_INT_MAX);
        $this->maxValues = array_fill(0, $numFeatures, PHP_INT_MIN);

        // Loop through each sample and calculate min and max for each feature
        foreach ($samples as $sample) {
            foreach ($sample as $index => $value) {
                if ($value < $this->minValues[$index]) {
                    $this->minValues[$index] = $value;
                }
                if ($value > $this->maxValues[$index]) {
                    $this->maxValues[$index] = $value;
                }
            }
        }

        // Scale the dataset
        $scaledSamples = [];
        foreach ($samples as $sample) {
            $scaledRow = [];
            foreach ($sample as $index => $value) {
                // Ensure there is a valid range before scaling
                if ($this->maxValues[$index] - $this->minValues[$index] == 0) {
                    // If the range is 0, just return 0 for that feature (or keep the original value)
                    $scaledRow[$index] = 0;
                } else {
                    // Apply MinMax scaling
                    $scaledRow[$index] = ($value - $this->minValues[$index]) / ($this->maxValues[$index] - $this->minValues[$index]);
                }
            }
            $scaledSamples[] = $scaledRow;
        }

        // Return the transformed dataset
        return new Unlabeled($scaledSamples);
    }

    // Transform the data using the fitted scaler
    public function transform(Unlabeled $dataset): Unlabeled
    {
        $samples = $dataset->samples();
        
        // Check if the dataset is empty
        if (empty($samples)) {
            throw new \InvalidArgumentException("The dataset is empty. Cannot transform the data.");
        }

        // Ensure the scaler has been fitted before transformation
        if (empty($this->minValues) || empty($this->maxValues)) {
            throw new \LogicException("The scaler has not been fitted yet. Please call fitTransform() first.");
        }

        $scaledSamples = [];

        // Scale the dataset using the fitted min and max values
        foreach ($samples as $sample) {
            $scaledRow = [];
            foreach ($sample as $index => $value) {
                // Ensure there is a valid range before scaling
                if ($this->maxValues[$index] - $this->minValues[$index] == 0) {
                    // If the range is 0, return 0 for that feature
                    $scaledRow[$index] = 0;
                } else {
                    // Apply MinMax scaling
                    $scaledRow[$index] = ($value - $this->minValues[$index]) / ($this->maxValues[$index] - $this->minValues[$index]);
                }
            }
            $scaledSamples[] = $scaledRow;
        }

        // Return the transformed dataset
        return new Unlabeled($scaledSamples);
    }
}
