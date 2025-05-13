<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate CV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cv-output {
            background-color: #f8f9fa;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Generate Your CV</h1>
        <form id="cvForm">
            <div class="mb-3">
                <label for="user_input" class="form-label">Enter Your Details</label>
                <textarea class="form-control" id="user_input" name="user_input" rows="5" placeholder="Masukkan informasi seperti nama, pengalaman kerja, pendidikan, dll."></textarea>
            </div>
            <button type="submit" class="btn btn-primary" id="generate-cv-btn">Generate CV</button>
        </form>

        <div class="mt-5">
            <h3>Generated CV:</h3>
            <div id="generated-cv" class="cv-output"></div>
        </div>
    </div>

    <script>
        document.getElementById('cvForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const userInput = document.getElementById('user_input').value.trim();
            const resultDiv = document.getElementById('generated-cv');
            resultDiv.innerHTML = "Generating...";

            if (!userInput) {
                resultDiv.innerHTML = "<span style='color:red'>Silakan isi informasi Anda terlebih dahulu.</span>";
                return;
            }

            try {
                const response = await fetch('/api/generate-cv', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ user_input: userInput }),
                });

                const data = await response.json();

                if (data.success) {
                    // Jika backend mengembalikan HTML, tampilkan langsung
                    resultDiv.innerHTML = data.cv;
                } else {
                    resultDiv.innerHTML = "<span style='color:red'>" + (data.error || 'Gagal generate CV') + "</span>";
                }
            } catch (err) {
                resultDiv.innerHTML = "<span style='color:red'>Terjadi error pada server.</span>";
            }
        });
    </script>
</body>
</html>
