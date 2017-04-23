@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card-panel">
            <nav class="teal">
                <div class="nav-wrapper">
                    <form method="GET" action="search">
                        <div class="input-field">
                            <input id="q" name="q" type="search" required>
                            <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                            <i class="material-icons">close</i>
                        </div>
                    </form>
                </div>
            </nav>
            @if (isset($git_total_count) && isset($git_items))
                <ul class="collection">
                    @if ($git_total_count > 0)
                        @foreach ($git_items as $item)
                            <li class="collection-item">
                                <div><a target="_blank" href="{{ $item->html_url }}">{{ $item->full_name }}</a></div>
                                <div>{{ $item->description }}</div>
                            </li>
                        @endforeach
                    @else
                        <li class="collection-item">
                            Ничего не найдено.
                        </li>
                    @endif
                </ul>
                @if (isset($git_total_pages))
                    @if ($git_total_pages > 1)
                        <div class="row">
                            <div class="col s3 offset-s3">
                                @if ($page > 1)
                                    <a href="{{ $page_link }}&page={{ $page - 1 }}" class="waves-effect waves-light btn">Предыдущая</a>
                                @else
                                    <a href="#!" class="btn disabled">Предыдущая</a>
                                @endif
                            </div>
                            <div class="col s3">
                                @if ($page < $git_total_pages)
                                    <a href="{{ $page_link }}&page={{ $page + 1 }}" class="waves-effect waves-light btn">Следующая</a>
                                @else
                                    <a href="#!" class="btn disabled">Следующая</a>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif
            @endif
        </div>
    </div>
@stop