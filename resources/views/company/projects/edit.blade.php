@extends('layouts.app')
@section('title', 'Edit Project')

@section('content')

    @include('company.projects._form', [
        'project' => $project,
        'route' => route('company.projects.update', $project),
        'method' => 'PUT',
        'buttonText' => 'Save Changes',
        'isEdit' => true,
    ])

@endsection
