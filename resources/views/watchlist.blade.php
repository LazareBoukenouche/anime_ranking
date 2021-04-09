<x-layout>
  <ul role="list" class="anime-list">
    @foreach($animes as $anime)
      <li class="flow">
        <div class="flow">
        <h1>Watchlist</h1>
          <div>
            <img alt="" src="/covers/{{ $anime->cover }}" />
          </div>
          <h2>
            {{ $anime->title }}
          </h2>
        </div>
        <a class="cta" href="/anime/{{ $anime->id }}">Voir</a>
      </li>
    @endforeach
  </ul>
</x-layout>
