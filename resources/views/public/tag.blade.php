@extends('layouts.app')
@include('layouts.navigation')

@section('title', 'Tag: ' . $tag->nome)

@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow section-bracket">Tag</p>
            <h1 class="page-header__title">{{ $tag->nome }}</h1>
        </div>
    </div>

    @php
        $fotosPublicas = $tag->fotos->where('publico', true);
    @endphp

    @if($fotosPublicas->count())
        <div class="grid-masonry">
            @foreach($fotosPublicas as $foto)
                <div class="card">
                    @if($foto->imagem)
                        <a href="{{ route('public.foto', $foto) }}">
                            <img src="{{ Storage::url($foto->imagem) }}" alt="{{ $foto->titulo }}"
                                 class="card__img">
                        </a>
                    @endif
                    <div class="card__body">
                        <p class="card__title">
                            <a href="{{ route('public.foto', $foto) }}" style="text-decoration:none;color:inherit;">
                                {{ $foto->titulo }}
                            </a>
                        </p>
                        <p class="card__meta">{{ $foto->user->name }}</p>

                        @if(!empty($foto->imagem))
                            <a href="{{ route('foto.download', ['filename' => $foto->imagem]) }}" download class="btn btn-dowload">
                                Baixar Imagem
                            </a>
                        @else
                            <button class="btn btn-secondary" disabled title="Nenhum arquivo disponível">
                                Sem Imagem
                            </button>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state__icon">X</div>
            <p class="empty-state__title">Sem fotos nesta tag</p>
            <p class="empty-state__text">Nenhuma foto pública foi marcada com "{{ $tag->nome }}".</p>
        </div>
    @endif

@endsection
