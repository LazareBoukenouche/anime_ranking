<x-layout>
  <x-slot name="title">
    {{ $anime->title }}
  </x-slot>
  
  <article class="anime">
    <header class="anime--header">
    
      <div>
        <img alt="" src="/covers/{{ $anime->cover }}" />
      </div>
      <h1>{{ $anime->title }}</h1>
      
    </header>

    <aside>
    <span>@if ($has_review)
      <h2> {{$rating }}</h2>
    @endif</span></aside>
    
    <p>{{ $anime->description }}</p>
    <div>
      <div class="actions">
        <div>
        @if ($has_review)
        
          <a class="cta" href="/anime/{{ $anime->id }}/modify_review">Modifier critique</a>
          
        @else
        <a class="cta" href="/anime/{{ $anime->id }}/new_review">Écrire une critique</a>
        @endif
  
        
          
        </div>
        
          
          @if (Auth::check())
            @if ($in_watchlist)
          <form action="/anime/{{ $anime->id }}/delete_from_watch_list" method="POST">
            @csrf
              <button class="cta">Retirer de ma watchlist</button>
          </form>    
            @else
        <form action="/anime/{{ $anime->id }}/add_to_watch_list" method="POST">
          @csrf
            <button class="cta">Ajouter à ma watchlist</button>
        </form>
            @endif
          @else
            <a class="cta" href="/login">Ajouter à ma watchlist</a>
          @endif
        </form>
      </div>
    </div>
  </article>
</x-layout>
