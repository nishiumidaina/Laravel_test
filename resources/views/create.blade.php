@extends('layouts.app')

@section('content')
<div class="row justify-content-center ml-0 mr-0 h-100">
    <div class="card w-100">
        <div class="card-header">登録</div>
        <div class="card-body">
            <form method='POST' action="/store">
                @csrf
                <input type='hidden' name='user_id' value="{{ $user['id'] }}">

                <div class="form-group">
                    <label for="name">地点名</label>
                    <input name='name' type="text" class="form-control" id="name" placeholder="地点名を入力">
                    <label for="latitude">経度</label>
                    <input name='latitude' type="text" class="form-control" id="latitude" placeholder="経度を入力">
                    <label for="longitude">緯度</label>
                    <input name='longitude' type="text" class="form-control" id="longitude" placeholder="緯度を入力">
                    <label for="url">動画URL</label>
                    <input name='url' type="text" class="form-control" id="url" placeholder="動画URLを入力">
                    <label for="ex">説明</label>
                    <input name='ex' type="text" class="form-control" id="ex" placeholder="観光地の説明を入力">
                </div>
                <button type='submit' class="btn btn-primary btn-lg">保存</button>
            </form>
        </div>
    </div>
</div>
@endsection