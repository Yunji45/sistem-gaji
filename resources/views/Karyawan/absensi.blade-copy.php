@extends('masterFile')

@section('content')

<div class="container">
    <h1>Absensi</h1>
    <button id="checkInBtn">Check In</button>
    <button id="checkOutBtn">Check Out</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function handleResponse(response) {
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Error response:', text);
                    throw new Error('Server returned an error');
                });
            }
            return response.json().then(data => {
                if (data.message) {
                    alert(data.message);
                }
            });
        }

        function handleError(error) {
            alert('Error retrieving location: ' + error.message);
        }

        function performCheck(url) {
            navigator.geolocation.getCurrentPosition(function(position) {
                let lat = position.coords.latitude;
                let lon = position.coords.longitude;
                console.log(`Latitude: ${lat}, Longitude: ${lon}`); 
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ latitude: lat, longitude: lon })
                })
                .then(handleResponse)
                .catch(error => {
                    alert('Error during fetch: ' + error.message);
                });
            }, handleError);
        }

        document.getElementById('checkInBtn').addEventListener('click', function() {
            performCheck('/check-in');
        });

        document.getElementById('checkOutBtn').addEventListener('click', function() {
            performCheck('/check-out');
        });
    });
</script>

@endsection
