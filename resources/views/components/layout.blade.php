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
    <nav class="bg-default-green text-white">
      
        @auth
          <div class="flex items-center space-x-4">
            <span class="mr-4">Logged in as {{ Auth::user()->name }}</span>
            <form method="POST" action="/logout" class="inline">
              @csrf
              <button type="submit" class="navbar-button-invert">Logout</button>
            </form>
          
        @else
          <ul class="flex space-x-4">
            <li><a href="/login" class="navbar-button-invert">Login</a></li>
            <li><a href="/register" class="navbar-button-invert">Register</a></li>
          </ul>
        @endauth
        </div>
      </div>
    </nav>

    <main class="container mx-auto p-4">
      {{$slot}}
    </main>

  </body>
</html>
