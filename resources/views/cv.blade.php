<!DOCTYPE html>
<html lang="en" class="bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate CV</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
    .cv-preview h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-align: center;
    }
    .cv-preview h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2563eb;
        margin-top: 1.5rem;
        margin-bottom: 0.5rem;
        border-bottom: 1px solid #cbd5e1;
        padding-bottom: 0.15em;
    }
    .cv-preview p {
        margin-bottom: 0.25rem;
        line-height: 1.7;
    }
    .cv-preview ul, .cv-preview ol {
        margin: 0.25rem 0 0.5rem 1.5rem;
        padding-left: 1.3rem;
    }
    .cv-preview li {
        margin-bottom: 0.2rem;
        list-style: disc;
    }
    .cv-preview {
        font-size: 1rem;
        line-height: 1.7;
    }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 transition-colors duration-300">
    <div class="w-full max-w-2xl mx-auto bg-white rounded-lg shadow p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Generate Your CV</h1>
        <form id="cvForm" class="space-y-5">
            <div>
                <label for="user_input" class="block font-medium text-gray-700 mb-2">Enter Your Details</label>
                <textarea
                    class="w-full rounded border border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm min-h-[120px] p-3 bg-white text-gray-800"
                    id="user_input"
                    name="user_input"
                    rows="5"
                    placeholder="Masukkan informasi seperti nama, pengalaman kerja, pendidikan, dll."></textarea>
            </div>
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold transition-colors"
                id="generate-cv-btn">
                Generate CV
            </button>
        </form>

        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-3 text-gray-800">Generated CV:</h3>
            <div id="generated-cv" class="bg-gray-50 border border-gray-200 rounded p-5 min-h-[80px] text-gray-800 cv-preview"></div>
        </div>
    </div>

    <script>
        document.getElementById('cvForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const userInput = document.getElementById('user_input').value.trim();
            const resultDiv = document.getElementById('generated-cv');
            resultDiv.innerHTML = "Generating...";

            if (!userInput) {
                resultDiv.innerHTML = "<span class='text-red-600'>Silakan isi informasi Anda terlebih dahulu.</span>";
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
                    resultDiv.innerHTML = data.cv;
                } else {
                    resultDiv.innerHTML = "<span class='text-red-600'>" + (data.error || 'Gagal generate CV') + "</span>";
                }
            } catch (err) {
                resultDiv.innerHTML = "<span class='text-red-600'>Terjadi error pada server.</span>";
            }
        });
    </script>
</body>
</html>