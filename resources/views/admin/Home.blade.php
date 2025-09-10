<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-md rounded-lg p-8 max-w-md text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Welcome to the Home Page</h1>

        <p class="text-gray-600 mb-6">
            You are successfully logged in.
        </p>

        <form method="POST" action="/logout">
            @csrf
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Logout
            </button>
        </form>
    </div>

</body>

</html>
