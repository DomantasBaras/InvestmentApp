<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Investment - Investment App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Create New Investment</h1>
                <a href="{{ route('investments.index') }}" 
                   class="text-blue-600 hover:text-blue-900">
                    Back to List
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow p-6">
                <form method="POST" action="{{ route('investments.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700 font-bold mb-2">
                            Investment Amount (EUR)
                        </label>
                        <input type="number"
                               name="amount"
                               id="amount"
                               step="0.01"
                               value="{{ old('amount') }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Create Investment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>