<x-layout title="EcoScan">
  <h1 class="center-title">EcoScan Home</h1>

  <form method="GET" action="/bands" class="mb-6">
    <div class="flex items-center">
        <input type="text" name="search" placeholder="Search for a band" value="{{ request('search') }}" class="input-field" />
        

        <button type="submit" class="bordered-submit-button">Search</button>
    </div>
</form>

</x-layout>
