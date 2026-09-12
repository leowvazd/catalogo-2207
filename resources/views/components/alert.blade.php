@if (session()->has('success'))
            <div>
                <h1 class="h4 mb-0 text-gray-800">
                    <i class="bi bi-people-fill text-primary me-2"></i>
                    {{ session('success') }}
                </h1>
            </div>
@endif

@if (session()->has('message'))
            <div>
                <h1 class="h4 mb-0 text-gray-800">
                    <i class="bi bi-people-fill text-yellow me-2"></i>
                    {{ session('success') }}
                </h1>
            </div>
@endif

@if (session()->has('error'))
            <div>
                <h1 class="h4 mb-0 text-gray-800">
                    <i class="bi bi-people-fill text-danger me-2"></i>
                    {{ session('success') }}
                </h1>
            </div>
@endif

@if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
@endif