@extends('backstage.templates.backstage')

@section('tools')
    <a href="{{ route('backstage.symbols.index') }}" class="button-default">Symbols</a>
@endsection

@section('content')
    <div id="card" class="bg-white shadow-lg mx-auto rounded-b-lg">
        <div class="px-10 pt-4 pb-8">
            <h1>Create a new Symbols</h1>
            <form method="POST" action="{{ route('backstage.symbols.store') }}" enctype="multipart/form-data">
                @csrf

                @include('backstage.partials.forms.text', [
                    'field' => 'name',
                    'label' => 'Name',
                    'value' => old('name') ?? '',
                ])

                @include('backstage.partials.forms.number', [
                    'field' => 'match_point_3',
                    'label' => 'Match Point 3',
                    'value' => old('match_point_3') ?? 0,
                ])

                @include('backstage.partials.forms.number', [
                    'field' => 'match_point_4',
                    'label' => 'Match Point 4',
                    'value' => old('match_point_4') ?? 0,
                ])

                @include('backstage.partials.forms.number', [
                    'field' => 'match_point_5',
                    'label' => 'Match Point 5',
                    'value' => old('match_point_5') ?? 0,
                ])

                @include('backstage.partials.forms.file', [
                    'field' => 'image',
                    'label' => 'Image',
                    'value' => old('image') ?? '',
                ])

                @include('backstage.partials.forms.submit')
            </form>
        </div>
    </div>
@endsection
