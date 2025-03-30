document.addEventListener("DOMContentLoaded", function () {
    fetch('http://127.0.0.1:8000/forecast')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log("Fetched Data: ", data);

            // Check if data is received
            if (!data || data.length === 0) {
                throw new Error('No data received from the server');
            }

            const labels = data.map(entry => new Date(entry.month).toLocaleString('default', { month: 'long', year: 'numeric' }));
            const predictions = data.map(entry => entry.predicted_sales);

            // Log labels and predictions
            console.log("Chart Labels: ", labels);
            console.log("Chart Data: ", predictions);

            // Code to render the chart...
        })
        .catch(error => console.error('Error fetching forecast:', error));
});
