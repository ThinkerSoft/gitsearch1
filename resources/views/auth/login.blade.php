@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card col s6 offset-s3">
                <form method="GET" action="/login/github">
                    {{ csrf_field() }}
                    <div class="card-content">
                        <div>
                            <h4 class="center-align">GitHub</h4>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">account_box</i>
                            <input d="email" name="email" type="text" class="validate">
                            <label for="email">Логин</label>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">lock</i>
                            <input id="password" name="password" type="password" class="validate">
                            <label for="password">Пароль</label>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn waves-effect waves-light">
                            Вход
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop