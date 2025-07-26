<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex items-center justify-center min-h-screen p-6">
    <div class="max-w-3xl bg-white shadow-lg rounded-lg p-10 text-center space-y-6 border-t-4 ">
        <div>
            <h1 class="text-4xl font-extrabold text-blue-800 drop-shadow-md">Sistem Penunjang Keputusan</h1>
            <h2 class="text-2xl text-gray-700 font-semibold mt-2">Penentuan Karyawan Terbaik</h2>
        </div>
        
        <p class="text-gray-600 leading-relaxed">
            Selamat datang di sistem penunjang keputusan <strong class="text-blue-700">PT. Unilab Perdana</strong>.  
            Aplikasi ini menggunakan metode <strong class="text-blue-700">AHP (Analytical Hierarchy Process)</strong> untuk membantu menentukan 
            karyawan terbaik berdasarkan berbagai kriteria dan subkriteria yang telah ditentukan.
        </p>
        
        <div>
            <a href="{{ route('login') }}" 
               class="bg-blue-600 text-white px-8 py-3 rounded-lg shadow-md 
                      hover:bg-blue-700 hover:shadow-lg hover:scale-105 transition transform duration-300 ease-in-out text-lg font-medium">
                Masuk ke Sistem
            </a>
        </div>
        <diV class="max-w-7xl mx-auto py-2 px-2 mb-2">
            <p class="text-base text-[#565d59] text-center mt-2">
                    &copy; {{ date('Y') }} Ibnu Nur Azis - Semua Hak Dilindungi.
                    
                </p>
            </diV>
    </div>
</body>
</html>
