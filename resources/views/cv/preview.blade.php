<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview CV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Preview CV</h1>

        <!-- Preview CV -->
        <div id="cvPreview" class="border p-3 mb-3">
            {!! $generatedCV !!}
        </div>

        <!-- Tombol Edit dan Download -->
        <a href="#" class="btn btn-primary" onclick="toggleEdit()">Edit CV</a>
        <a href="{{ route('cv.download') }}" class="btn btn-success">Download PDF</a>

        <!-- Form Edit CV -->
        <form id="editCvForm" action="{{ route('cv.save') }}" method="POST" style="display: none;" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="cv_content" class="form-label">Edit CV</label>
                <textarea class="form-control" id="cv_content" name="cv_content" rows="10">{{ $generatedCV }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </form>
    </div>

    <script>
        function toggleEdit() {
            const preview = document.getElementById('cvPreview');
            const form = document.getElementById('editCvForm');

            if (form.style.display === 'none') {
                form.style.display = 'block';
                preview.style.display = 'none';
            } else {
                form.style.display = 'none';
                preview.style.display = 'block';
            }
        }
    </script>
</body>
</html>