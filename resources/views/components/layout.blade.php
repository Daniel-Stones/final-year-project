<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{$title}}</title>
    <link href="{{ asset('css/style.css') }}" type="text/css" rel="stylesheet" />
  </head>

  <body class="bg-default-grey font-sans text-gray-800">
    <nav class="bg-default-green text-white px-4 py-2">
      <div class="flex justify-between items-center">
        <div>
          <a href="/" class="text-xl font-bold">EcoScan</a>
        </div>

        <div>
          @auth
            <div class="flex items-center space-x-4">
              <span>Logged in as {{ Auth::user()->name }}</span>
              <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="navbar-button-invert">Logout</button>
              </form>
            </div>
          @else
            <ul class="flex space-x-4 items-center">
              <li><a href="/login" class="navbar-button-invert">Login</a></li>
              <li><a href="/register" class="navbar-button-invert">Register</a></li>
            </ul>
          @endauth
        </div>
      </div>
    </nav>

    <main class="container mx-auto p-4">
      <form method="GET" action="/result" class="mb-6">
        <div class="flex items-center space-x-2">
          <input 
            type="text" 
            name="barcode" 
            placeholder="Search with product barcode" 
            value="{{ request('barcode') }}" 
            class="input-field h-12" 
          />
          <button type="submit" class="bordered-submit-button">Search</button>
          <a href="/" class="bordered-submit-button inline-block text-center">Scan a barcode</a>
        </div>
      </form>
      {{$slot}}
    </main>

  </body>
</html>