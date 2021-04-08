<x-layout>
  <x-slot name="title">
    Nouvelle critique de {{ $anime->title }}
  </x-slot>

  <h1>Nouvelle Critique de {{ $anime->title }}</h1>

  <form action="/anime/{{ $anime->id }}/new_review" method="POST">
        @csrf
        <div class="input-group">
          <label for="rating">Rating</label>
          <input id="rating" name="rating" type="range" min=0 max=10 required />
          @error('rating')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>

        <div class="input-group">
          <label for="comment">Critique</label>
          <input id="comment" name="comment" type="textarea" required />
          @error('comment')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>

        <button> Créer </button>
</x-layout>
