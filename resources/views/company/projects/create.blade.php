@extends('layouts.app')
@section('title', 'New Project')

@section('content')

    @include('company.projects._form', [
        'project' => null,
        'route' => route('company.projects.store'),
        'method' => 'POST',
        'buttonText' => 'Create Project',
        'isEdit' => false,
    ])

@endsection
